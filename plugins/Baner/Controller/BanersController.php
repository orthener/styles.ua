<?php

class BanersController extends AppController {

    public $name = 'Baners';
    public $layout = 'admin';
    public $components = array('Cookie', 'Filtering');
    public $uses = array('Baner.Baner');
    public $helpers = array('Image.Image', 'FebTinyMce');

    public function beforeFilter() {
        parent::beforeFilter();
        $groupTypes = $this->Baner->groupTypes;
        $this->set(compact('groupTypes'));
        $this->Auth->allow(array('get_baner', 'rd'));
    }

    /**
     * Lista wszystkich banerów 
     */
    public function admin_index() {
        $this->Baner->recursive = -1;
        $this->set('baners', $this->paginate());
    }

    /**
     * Funkcja redirectujaca
     */
    public function rd($id = null) {
        if (!$id) {
            throw new NotFoundException(__d('cms', 'Nie odnaleziono'));
        }

        $userBanerClicked = $this->Cookie->read('Baner.Clicked');

        if (!is_array($userBanerClicked)) {
            $userBanerClicked = array();
        }

        if (!in_array($id, $userBanerClicked)) {
            $this->counterUp($id);
        }

        $baner = $this->Baner->read(array('url'), $id);

        if (strpos($baner['Baner']['url'], 'http://') === false) {
            $baner['Baner']['url'] = 'http://' . $baner['Baner']['url'];
        }

        $this->redirect($baner['Baner']['url']);

        $this->render(false);
    }

    /**
     * Zwiększa licznik banera
     * 
     * @param type $id
     * @return boolean 
     */
    private function counterUp($id = null) {
        //Logika do countera, na dzien dzisiejszy bez ograniczen po za coockie

        $data['BanerClick']['baner_id'] = $id;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $data['BanerClick']['ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $data['BanerClick']['ip'] = $_SERVER['REMOTE_ADDR'];
        }

        $this->Baner->BanerClick->save($data);

        //To-Do boty nie powinny dodawac do licznika
        $this->Baner->query("UPDATE `baners` SET `clicks_counter` = `clicks_counter` + 1 WHERE `id` = {$id}");
        $userBanerClicked = $this->Cookie->read('Baner.Clicked');

        if (!is_array($userBanerClicked)) {
            $userBanerClicked = array();
        }

        $userBanerClicked[] = $id;
        $this->Cookie->write('Baner.Clicked', $userBanerClicked, false, '30 Days');
        $userBanerClicked = $this->Cookie->read('Baner.Clicked');

        return true;
    }

    /**
     * Metoda pobiera baner
     * 
     * @param type $group
     * @throws MethodNotAllowedException
     * @throws NotFoundException 
     */
    public function get_baner($group = null, $limit = 1) {
        $this->layout = 'ajax';

        if (!$this->request->is('requested')) {
            throw new MethodNotAllowedException();
        }

        if (!$group) {
            throw new NotFoundException(__d('cms', 'Nie odnaleziono'));
        }

        $params['conditions']['Baner.published'] = 1;
        $params['conditions']['Baner.group'] = $group;
        $params['conditions'][] = 'Baner.publish_date < NOW()';
        $params['limit'] = $limit;
        $params['order'] = "RAND()";
        $this->Baner->recursive = -1;
        $baners = $this->Baner->find('all', $params);

        //Są jakieś banery do publikacji
        foreach ($baners as $baner) {
            $status = true;

            //Limit jest ustawiony i licznik kliknięć jest większy od limitu
            if ($baner['Baner']['clicks_limit'] && $baner['Baner']['clicks_counter'] > $baner['Baner']['clicks_limit']) {
                $status = false;
            }

            //Limit wyświetleń jest ustawiony i licznik jest wiekszy
            if ($baner['Baner']['shows_limit'] && $baner['Baner']['shows_counter'] > $baner['Baner']['shows_limit']) {
                $status = false;
            }

            //Koniec daty publikacji
            if ($baner['Baner']['date_limit'] && time() > strtotime($baner['Baner']['date_limit'])) {
                $status = false;
            }

            if (!$status) {
                //ustawiam flagę published aby go nie wyszukiwał i wywołuje rekorencje
                $this->Baner->id = $baner['Baner']['id'];
                $this->Baner->saveField('published', 0);

                $this->get_baner($group);
            }

            //podbijam counter odwiedzonego
            $this->Baner->query("UPDATE `baners` SET `shows_counter` = `shows_counter` + 1 WHERE `id` = {$baner['Baner']['id']}");

            $data['BanerShow']['baner_id'] = $baner['Baner']['id'];
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $data['BanerShow']['ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $data['BanerShow']['ip'] = $_SERVER['REMOTE_ADDR'];
            }
            $this->Baner->BanerShow->save($data);
        }

        $this->set(compact('baners'));
        $this->render('get_baner');
    }

    public function admin_add() {
        if (!empty($this->request->data)) {
            $this->request->data['Baner']['user_id'] = $this->Auth->user('id');
            $this->Baner->create();
            if ($this->Baner->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'The baner has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'The baner could not be saved. Please, try again.'));
            }
        }
    }

    public function admin_edit($id = null) {
        $this->Baner->recursive = -1;
        $params = array();
        $params['conditions']['Baner.id'] = $id;
        $baner = $this->Baner->find('all', $params);
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__d('cms', 'Invalid baner'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {

            if ($this->Baner->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'The baner has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'The baner could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Baner->read(null, $id);

            if ($this->request->data['Baner']['html_code']) {
                $this->request->data['Baner']['banerType'] = 0;
            }

            if ($this->request->data['Baner']['image']) {
                $this->request->data['Baner']['banerType'] = 1;
            }
        }
        $this->set('baner',$baner);
    }

    public function admin_delete($id = null) {
        $this->Baner->id = $id;
        if (!$this->Baner->exists()) {
            throw new NotFoundException(__d('cms', 'Invalid id for baner'));
        }
        if ($this->Baner->delete($id)) {
            $this->Session->setFlash(__d('cms', 'Baner deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('cms', 'Baner was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    //*

    public function admin_baner_stats() {
        $baners = $this->Baner->find('list');
        $this->set(compact('baners'));
    }

    /**
     * Metoda wypelnia tablice kluczami dat w zadanym okresie, wykorzystywana glownie do wykresow
     * 
     * @param type $strDateFrom
     * @param type $strDateTo
     * @param type $fillAt
     * @return null 
     */
    private function createDateRangeKeyArray($strDateFrom, $strDateTo, $fillAt = null, $format = 'Y-m-d') {
        $aryRange = array();

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            $aryRange[date($format, $iDateFrom)] = $fillAt;

            while ($iDateFrom < $iDateTo) {
                $iDateFrom+=86400; // add 24 hours
                $aryRange[date($format, $iDateFrom)] = $fillAt;
            }
        }
        return $aryRange;
    }

    /**
     * Akcja wyciągające dane do wygenerowania wykresu graficznego
     *
     * @throws InvalidMethodException 
     */
    public function admin_get_chart_clicks() {
        $this->layout = 'ajax';

        //Test
//        $_POST['type'] = 3;
//        $_POST['datePickerFrom'] = "2011-09-08";
//        $_POST['dataPickerTo'] = "2011-11-30";
//        
        if (empty($_POST['datePickerFrom']) || empty($_POST['dataPickerTo'])) {
            throw new Exception('Tylko post');
            ;
        }

        $format = 'Y-m-d';
        switch ($_POST['type']) {
            case "1":
                //Dni
                $format = 'Y-m-d';
                $params['fields'] = array('COUNT(`id`) as `ile`', 'DATE_FORMAT(`created`, \'%Y-%m-%d\') as `dzien`');
                $params['group'] = "DATE_FORMAT(`created`, '%Y-%m-%d')";
                break;
            case "2":
                //Miesiace
                $format = 'Y-m';
                $params['fields'] = array('COUNT(`id`) as `ile`', 'DATE_FORMAT(`created`, \'%Y-%m\') as `dzien`');
                $params['group'] = "DATE_FORMAT(`created`, '%Y-%m')";
                break;
            case "3":
                //Lata
                $format = 'Y';
                $params['fields'] = array('COUNT(`id`) as `ile`', 'DATE_FORMAT(`created`, \'%Y\') as `dzien`');
                $params['group'] = "DATE_FORMAT(`created`, '%Y')";
                break;
        }
        $preperyData = $this->createDateRangeKeyArray($_POST['datePickerFrom'], $_POST['dataPickerTo'], array('clicks' => 0, 'shows' => 0), $format);

        $params['conditions']['created >='] = $_POST['datePickerFrom'];
        $params['conditions']['created <='] = $_POST['dataPickerTo'];

        if (!empty($_POST['banerId'])) {
            $params['conditions']['baner_id'] = $_POST['banerId'];
        }

        $params['order'] = 'created ASC';
        $this->Baner->BanerShow->recursive = -1;
        $sqlDataShows = $this->Baner->BanerShow->find('all', $params);

        $this->Baner->BanerClick->recursive = -1;
        $sqlDataClicks = $this->Baner->BanerClick->find('all', $params);

        foreach ($sqlDataShows as $k => $obj) {
            $preperyData[$obj[0]['dzien']]['shows'] = $obj[0]['ile'];
        }
        foreach ($sqlDataClicks as $k => $obj) {
            $preperyData[$obj[0]['dzien']]['clicks'] = $obj[0]['ile'];
        }
        //Format daty oraz wypełnienie przygotowanej
        $data = array();

        foreach ($preperyData as $dateFormated => $obj) {
            switch ($_POST['type']) {
                case "1":
                    //Dni
                    $dayFormat = date('d M', strtotime($dateFormated));
                    $data[$dayFormat] = $obj;
                    break;
                case "2":
                    //Miesiace
                    $monthFormat = date('M Y', strtotime($dateFormated));
                    $data[$monthFormat] = $obj;
                    break;
                case "3":
                    //Lata
                    $yearFormat = date('Y', strtotime($dateFormated));
                    $data[$yearFormat] = $obj;
                    break;
            }
        }

        $preperyToDisplay = array();
        foreach ($data as $k => $v) {
            $preperyToDisplay[] = array((string) $k, (int) $v['shows'], (int) $v['clicks']);
        }
        echo json_encode($preperyToDisplay);
        $this->render(false);
        return $preperyToDisplay;
    }

}
