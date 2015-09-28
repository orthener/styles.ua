<?php
/************
* Kontroler wykorzystywany jest do wyswietlania stron glownych paneli administracyjnych
* Przyklad: /admin/panel, /private/panel itd.
*/
class PanelController extends AppController
{
  	var $layout = 'admin';
	var $name = 'Panel';
	var $uses = array('GoogleAnalytics.GoogleAnalyticsAccount');
	var $helpers = array('Text');
    
    var $GAtableID = null;

    function beforeFilter(){
        parent::beforeFilter();
        $this->GAtableID = Configure::read('GoogleAnalytics.default.tableID');
    }
    
    function admin_simple(){
        
    }

    function admin_ga_tableslist($tableID = null){
    
        @unlink(CACHE.'views'.DS.'element_cache_cms_analytics_xychart');
        
        if($this->GAtableID != null){
            if(!empty($this->params['requested'])){
                return null;
            }
            $this->redirect(array('admin'=>'admin', 'controller' => 'panel', 'action' => 'index'));
        }

        if($tableID != null){
            $data = '<'."?php\n    ";
            $data .= "Configure::write('GoogleAnalytics.default.tableID', '{$tableID}');\n";
            $data .= '?'.'>';
            file_put_contents(APP.'config'.DS.'bootstrap'.DS.'ga.table.php', $data);
            $this->redirect(array('admin'=>'admin', 'controller' => 'panel', 'action' => 'index'));
        }

        $accounts = $this->GoogleAnalyticsAccount->find('all');
        
        if(!empty($accounts[0])){
            return $accounts;
        }
        return;
    }


    function admin_chart(){
        if($this->GAtableID == null){
            return false;
        }
    
        $params = array(
            'start-date' => date('Y-m-d', strtotime('-1 month -1 day')),
            'end-date' => date('Y-m-d', strtotime('-1 day')),
            'dimensions' => array('date'),
            'metrics' => array('visits', 'visitors'),
            'sort' => array(),
        );
        
        $conditions['conditions'] = array_merge(
            array('tableId' => $this->GAtableID), $params);

        $data = $this->GoogleAnalyticsAccount->find('all', $conditions);

        $this->set('xychart', $data);
        return $data;
    }

    function admin_chart2(){
        if($this->GAtableID == null){
            return;
        }

        $params = array(
            'start-date' => date('Y-m-d', strtotime('-1 month -1 day')),
            'end-date' => date('Y-m-d', strtotime('-1 day')),
            'dimensions' => array('medium'),
            'metrics' => array('visits'),
            'sort' => array('-visits'),
        );
        
        $conditions['conditions'] = array_merge(
            array('tableId' => $this->GAtableID), $params);

        $data = $this->GoogleAnalyticsAccount->find('all', $conditions);
        
        $this->set('chart', $data);

        return $data;
    }

    function admin_analytics_sources(){
        if($this->GAtableID == null){
            return;
        }

        $params = array(
            'start-date' => date('Y-m-d', strtotime('-1 month -1 day')),
            'end-date' => date('Y-m-d', strtotime('-1 day')),
            'dimensions' => array('source'),
            'metrics' => array('visits'),
            'sort' => array('-visits'),
        );
        $conditions['conditions'] = array_merge(
            array('tableId' => $this->GAtableID), $params);
        $conditions['limit'] = 10;

        $data = $this->GoogleAnalyticsAccount->find('all', $conditions);
        $this->set('chart', $data);
        return $data;
    }

    function admin_analytics_page_path(){
        if($this->GAtableID == null){
            return;
        }

        $params = array(
            'start-date' => date('Y-m-d', strtotime('-1 month -1 day')),
            'end-date' => date('Y-m-d', strtotime('-1 day')),
            'dimensions' => array('pagePath'),
            'metrics' => array('pageviews'),
            'sort' => array('-pageviews'),
        );
        $conditions['conditions'] = array_merge(
            array('tableId' => $this->GAtableID), $params);
        $conditions['limit'] = 10;

        $data = $this->GoogleAnalyticsAccount->find('all', $conditions);
        $this->set('chart', $data);
        return $data;
    }

    /*****************
    * @desc Strona glowna panelu administracyjnego
    */
	function admin_index(){

    }
    
        
    

}
?>
