<?php
App::import('Core', array('HttpSocket', 'Xml', 'Cache'));

Cache::config('GACache', array(
    'engine' => 'File',
    'duration'=> '+1 week',
    'path' => CACHE . 'persistent' . DS,
));

class GoogleAnalyticsSource extends DataSource
{
    var $Http = null;
    var $token = '';
    var $base_url = 'https://www.google.com/';
    var $_baseConfig = array(
        'datasource' => 'google_analytics',
        'Email' => '',
        'Passwd' => '',
        'persistent' => true);
    var $cacheSources = false;

    var $accountsData = null;

    function __construct($config, $autoConnect = true)
    {
        parent::__construct($config);
        $this->Http =& new HttpSocket();
        if ($autoConnect AND !$this->connected())
        {
            return $this->connect();
        }
        return true;
    }

    function __destruct()
    {
        $this->close();
        parent::__destruct();
    }

    function connected()
    {
    	if (($GAtoken = Cache::read('GAtoken', 'GACache')) === false) {
            return false;
    	}

        $this->token = $GAtoken;
//         $this->token = 'Auth=DQAAAI8AAAD0DqGWAT5H2JXvu20WSdarZZ7ANDvgMCeOQowvPo23ZRcGO_D9jMiS8e7ScUbGlaYKZ5bWgSojkq_T9mGhbOUd10tT29_55AnR4KlpRfHc_VaygFj_0DXYhdyKC1zo1nq0S_YFZeNdD2QPZ95HT5nYwBYCJi4s84vCyTq8gnVoZE67ZnKj1OjuAYdDoQJWgDM';

        $this->accountsData = $this->get('analytics/feeds/accounts/default');

//         debug($this->Http->response); exit;
// 
        if ($this->Http->response['status']['code'] != 200)
        {
            return false;
        }

        return true;
    }

    function connect()
    {
        $this->close();

        $response = $this->post(
            'accounts/ClientLogin', array(
                'accountType' => 'GOOGLE',
                'Email' => $this->config['Email'],
                'Passwd' => $this->config['Passwd'],
                'service' => 'analytics',
                'source' => 'cakephp-gapi-0.1'));

        if ($this->Http->response['status']['code'] != 200)
        {
            return false;
        }

        preg_match('/Auth=(.*)/', $response, $matches);
        if (empty($matches))
        {
            return false;
        }
        $this->token = $matches[1];
        Cache::write('GAtoken', $this->token, 'GACache');
        return true;
    }

    function close()
    {
        $this->token = '';
        if($this->config['persistent'] == false){
            Cache::delete('GAtoken', 'GACache');
        }
    }

    function listSources()
    {
        return false;
    }

    function read(&$model, $queryData)
    {
    
        $this->presentModel = &$model;
        
        if (!empty($queryData['conditions']['tableId']))
        {
            return $this->account_data($queryData);
        }
        return $this->accounts();
    }

    function accounts()
    {
        if(empty($this->accountsData)){
            $this->accountsData = $this->get('analytics/feeds/accounts/default');
        }
        $results = $this->__to_array($this->accountsData);
        $entries = Set::extract('/Feed/Entry', $results);
        $data = array();
        foreach ($entries as $entry)
        {
            // sometimes the the keys are ucfirst'ed, sometimes not...
            $entry = array_change_key_case($entry['Entry'], CASE_LOWER);
            $accountId = $this->__extract_property_value(
                $entry, 'accountId');
            $accountName = $this->__extract_property_value(
                $entry, 'accountName');
            $profileId = $this->__extract_property_value(
                $entry, 'profileId');
            $webPropertyId = $this->__extract_property_value(
                $entry, 'webPropertyId');
            $account = array('Account' => array(
                'id' => $entry['id'],
                'updated' => $entry['updated'],
                'title' => $entry['title']['value'],
                'tableId' => str_replace('ga:', '', $entry['tableid']),
                'accountId' => $accountId,
                'accountName' => $accountName,
                'profileId' => $profileId,
                'webPropertyId' => $webPropertyId));
            $data[] = $account;
        }
        return $data;
    }

    function account_data($queryData)
    {
        $queryData = $this->__validateQueryData($queryData);

        $conditions = $queryData['conditions'];

        $defaultParams = array(
            'ids' => 'ga:'.$conditions['tableId'],
            'start-date' => strftime(
                '%Y-%m-%d', strtotime($conditions['start-date'])),
            'end-date' => strftime(
                '%Y-%m-%d', strtotime($conditions['end-date'])));

        $queryParams = $this->__buildParams($queryData);

        $params = array_merge($defaultParams, $queryParams);
        
        $results = $this->get('analytics/feeds/data', $params);

        $this->queryResults = $this->__to_array($results);

        $feed = $this->queryResults['Feed'];

        $data = $this->__dataPoints($feed);
        
        foreach($data AS &$val){
            $val = array($this->presentModel->alias => $val);
            
//             array(
//                 'tableId' => $feed['DataSource']['tableId'],
//                 'name' => $feed['DataSource']['tableName'],
//                 'totalResults' => $feed['totalResults'],
//                 'startIndex' => $feed['startIndex'],
//                 'itemsPerPage' => $feed['itemsPerPage'],
//                 'startDate' => $feed['startDate'],
//                 'endDate' => $feed['endDate'],
//                 'dataPoints' => $this->__dataPoints($feed),
//                 'aggregates' => $feed['Aggregates']
//             )));
        }
        return $data;
    }

    function __validateQueryData($queryData)
    {
        $conditions = $queryData['conditions'];
        if (empty($conditions['start-date']))
        {
            trigger_error(__d('cms', 'start-date is required', true), E_USER_ERROR);
            return null;
        }
        if (empty($conditions['end-date']))
        {
            trigger_error(__d('cms', 'end-date is required', true), E_USER_ERROR);
            return null;
        }
        if (empty($conditions['metrics']))
        {
            trigger_error(__d('cms', 'metrics is required', true), E_USER_ERROR);
            return null;
        }
        if (strtotime($conditions['start-date']) >
                strtotime($conditions['end-date']))
        {
            trigger_error(__d('cms', 'date order is reversed', true), E_USER_ERROR);
            return null;
        }
        if (!empty($conditions['dimensions']) &&
            is_array($conditions['dimensions']) &&
            count($conditions['dimensions']) > 7)
        {
            trigger_error(
                __d('cms', 'too many dimensions, the maximum allowed is 7'),
                E_USER_ERROR);
            return null;
        }
        if (!empty($conditions['metrics']) &&
            is_array($conditions['metrics']) &&
            count($conditions['metrics']) > 10)
        {
            trigger_error(
                __d('cms', 'too many metrics, the maximum allowed is 10'),
                E_USER_ERROR);
            return null;
        }
        if (!empty($conditions['sort']))
        {
            //TODO test sort conditions against passed dimensions and metrics
        }
        return $queryData;
    }

    function __buildParams($queryData)
    {
        $params = array();
        $conditions = $queryData['conditions'];
        if(!empty($queryData['limit'])){
            if(is_numeric($queryData['limit'])){
                $limit[0] = $queryData['limit'];
            } elseif(is_string($queryData['limit'])){
                $limit = explode(',', $queryData['limit']);
            } else {
                $limit = $queryData['limit'];
            }
            if(is_array($limit)){
                if(count($limit) == 1){
                    $params['max-results'] = trim($limit[0]);
                } else {
                    $params['start-index'] = trim($limit[0]);
                    $params['max-results'] = trim($limit[1]);
                }
            }
        }


        if (!empty($conditions['dimensions']))
        {
            if (!is_array($conditions['dimensions']))
            {
                $params['dimensions'] = 'ga:'.$conditions['dimensions'];
            }
            else
            {
                $params['dimensions'] = join(
                    array_map(
                        create_function('$x', 'return \'ga:\'.$x;'),
                        $conditions['dimensions']),
                    ',');
            }
        }

        if (!empty($conditions['metrics']))
        {
            if (!is_array($conditions['metrics']))
            {
                $params['metrics'] = 'ga:'.$conditions['metrics'];
            }
            else
            {
                $params['metrics'] = join(
                    array_map(
                        create_function('$x', 'return \'ga:\'.$x;'),
                        $conditions['metrics']),
                    ',');
            }
        }

        if (!empty($conditions['sort']))
        {
            if (!is_array($conditions['sort']))
            {
                if (substr($conditions['sort'], 0, 1) == '-')
                {
                    // move the - from the sort field to the front
                    $params['sort'] = '-ga:'.substr($conditions['sort'], 1);
                }
                else
                {
                    $params['sort'] = 'ga:'.$conditions['sort'];
                }
            }
            else
            {
                $sort = array();
                foreach ($conditions['sort'] as $s)
                {
                    if (substr($s, 0, 1) == '-')
                    {
                        // move the - from the sort field to the front
                        $sort[] = '-ga:'.substr($s, 1);
                    }
                    else
                    {
                        $sort[] = 'ga:'.$s;
                    }
                }
                $params['sort'] = join($sort, ',');
            }
        }
        return $params;
    }

    function __dataPoints($feed)
    {
        $dataPoint = array();
        if (empty($feed) || empty($feed['Entry']))
        {
            return array();
        }
        
        $dimension = $metric = array();
        $id = $updated = $title = '';

        foreach ($feed['Entry'] as $key => $val)
        {
            if (is_numeric($key))
            {
                $dimension = $metric = array();
                $id = $updated = $title = '';
                if (!empty($val['Dimension'])) $dimension = $val['Dimension'];
                if (!empty($val['Metric'])) $metric = $val['Metric'];
                if (!empty($val['id'])) $id = $val['id'];
                if (!empty($val['updated'])) $updated = $val['updated'];
                if (!empty($val['title']['value']))
                    $title = $val['title']['value'];
            }
            else
            {
                if ($key == 'id') $id = $val;
                if ($key == 'updated') $updated = $val;
                if ($key == 'Metric') $metric = $val;
            }
            $result = array(
                'id' => $id,
                'updated' => $updated,
                'title' => $title,
                'dimensions' => $this->__parseDataPoint($dimension),
                'metrics' => $this->__parseDataPoint($metric));
            $dataPoint[$key+0] = $result;
        }
        
        return $dataPoint;
    }

    function __parseDataPoint($dataPoint)
    {
        if (empty($dataPoint))
        {
            return array();
        }
        $result = array();
        foreach ($dataPoint as $key => $val)
        {
            if (!is_numeric($key))
            {
                $value = str_replace('ga:', '', $val);
                $result[$key] = $value;
            }
            else
            {
                foreach ($val as $name => $value)
                {
                    $value = str_replace('ga:', '', $value);
                    $result[$key][$name] = $value;
                }
            }
        }
        return $result;
    }

    function get($path = '', $params = array())
    {
        return $this->__request('get', $path, $params);
    }

    function post($path = '', $params = array())
    {
        return $this->__request('post', $path, $params);
    }

    function __request($method = 'get', $path = '', $params = array())
    {
        $method = strtolower($method);
        if (!in_array($method, array('get', 'post')))
        {
            return false;
        }
        $request = array('header' => array(
            'Authorization' => "GoogleLogin auth={$this->token}"));
        $response = $this->Http->{$method}(
            $this->base_url . $path, $params, $request);
        return $response;
    }

    function __to_array($response = '')
    {
        $xml = new XML($response);
        $array = $xml->toArray();
        $xml->_killParent();
        $xml->__destruct();
        $xml = null;
        unset($xml);
        return $array;
    }

    function __extract_property_value($entry, $property) {
        if (empty($entry) || empty($property)) {
            return '';
        }
        if (!is_array($entry) || !is_string($property)) {
            return '';
        }
        $value = Set::extract(
            "/property[name=ga:$property]/value", $entry);

        if (!empty($value[0])) {
            return $value[0];
        }
        return '';
    }
}