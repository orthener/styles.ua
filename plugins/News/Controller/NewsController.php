<?php

App::uses('AppController', 'Controller');

/**
 * News Controller
 *
 * @property News $News
 */
class NewsController extends AppController {
    /**
     * Nazwa layoutu
     */

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array(
        'Recaptcha.CaptchaTool',
        'FebForm',
        'FebTinyMce4',
        'Filter'
    );

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array('Filtering', 'Paginator');

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('get_news_to_front', 'index', 'view', 'blog', 'archiwum', 'search_blog', 'setup_slug', 'right_box','populars_promoted', 'author');
    }

    public function news_front() {
        $this->layout = false;
        $this->News->recursive = 0;
        $params['limit'] = 2;
        $params['order'] = "News.date DESC";
        $params['conditions']['News.is_published'] = 1;
        $news = $this->News->find('all', $params);
        //debug($news);
        $this->set(compact('news'));
        $this->render('news_front');
    }

    public function blog_front() {
        $this->layout = false;
        $this->News->recursive = 0;
        $params['limit'] = 5;
        $params['order'] = "News.created DESC";
        $params['conditions']['News.blog'] = 1;
        $news = $this->News->find('all', $params);
        $this->set(compact('news'));
        $this->render('news_front');
    }

    public function right_box($url = null, $category_slug = null, $news_id = null) {
        $this->layout = false;
        $this->loadModel('StaticProduct.Product');
        $this->helpers[] = 'FebTime';
        $this->helpers[] = 'Fancybox.Fancybox';
        $this->helpers[] = 'Time';
        
        $this->News->NewsCategory->locale = Configure::read('Config.languages');
        $this->News->NewsCategory->bindTranslation(array('name' => 'translateDisplay'));
        $promotedCategories = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.name'),
            'conditions' => array('NewsCategory.is_promoted' => 1),
        ));
        
        $paramsCategories = array();
        $paramsCategories['recursive'] = -1;
        $paramsCategories['joins'][] = array(
            'table' => 'news',
            'alias' => 'News',
            'type' => 'LEFT',
            'conditions' => array(
                'News.news_category_id = NewsCategory.id',
            )
        );
        $paramsCategories['group'] = array('NewsCategory.id');
        $paramsCategories['fields'] = array('NewsCategory.slug', 'NewsCategory.name, COUNT(News.id) AS count');
        $paramsCategories['order'] = 'name ASC';
        
        $newsCategoriesAll = $this->News->NewsCategory->find('all', $paramsCategories);
        
        $newsCategories = array();
        foreach($newsCategoriesAll as $newsCategory) {
            $newsCategories[$newsCategory['NewsCategory']['slug']] = $newsCategory['NewsCategory']['name'] . ' (' .$newsCategory[0]['count']. ')';
        }
        
        $this->filters = array(
            'News.year' => array('param_name' => "y", 'default' => ''),
            'News.month' => array('param_name' => "m", 'default' => ''),
        );
        $filtersParams = $this->Filtering->getParams();
        if (!empty($this->request->data)) {
            $params = $this->News->filterParams($this->request->data);
        }
        $this->set('filtersSettings', $this->filters);


        $params['conditions']['News.blog'] = 1;
        $params['conditions']['News.is_published'] = 1;
        if (!empty($category_slug)) {
            $params['conditions']['News.news_category_id'] = $id = $this->News->NewsCategory->getIdBySlug($category_slug);
        }
        $params['limit'] = 10;
        $params['recursive'] = 1;
        $params['order'] = 'News.date DESC';

        $this->paginate = $params;

        $params2['conditions']['News.blog'] = '1';
        $params2['group'] = 'year(News.date)';
        $params2['order'] = 'year DESC';
        $params2['recursive'] = -1;
        $params2['fields'] = array('count(News.id) as count', 'year(News.date) as year');
        $newsByYears = $this->News->find('all', $params2);
        $newsByYears = Set::combine($newsByYears, '{n}.0.year', '{n}.0');
        
//        debug($newsByYears);

        $params1['conditions']['News.blog'] = '1';
        $params1['group'] = 'month(News.date)';
        $params1['order'] = 'month DESC';
        $params1['recursive'] = -1;
        $params1['fields'] = array('count(News.id) as count', 'month(News.date) as month');
        
        $newsByMonths = array();  
        foreach($newsByYears as $key => $year) {
            $params1['conditions']['News.date >='] = $year['year'] . '-01-01 00:00:00';
            $params1['conditions']['News.date <='] = $year['year'] . '-12-31 23:59:59';
            $newsByMonths[$key] = $this->News->find('all', $params1);
            $newsByMonths[$key] = Set::combine($newsByMonths[$key], '{n}.0.month', '{n}.0');
        }
        $months = $this->getMonths();
        //$popularProducts = $this->Product->getPopularProducts();
//        $popularProducts = $this->Product->getPopularProductsByHit();
//
//        $params3['conditions']['Product.on_blog'] = 1;
//        $params3['order'] = 'RAND() DESC';
//        $params3['limit'] = 6;
//        $promotedOnBlog = $this->Product->find('all', $params3);

        $Ad = $this->getAdCode($category_slug, $news_id);
               
        $this->set(compact('newsCategories', 'newsByMonths', 'newsByYears', 'months', 'Ad', 'url', 'promotedCategories'));
        $this->render();
    }
    /**
     * Funkcja zwraca tablicę kodów reklam dla danej kategorii, a jeśli kategoria
     * jest pusta to zwraca kody domyślne
     * @param string $category_slug - slug kategorii
     */
    private function getAdCode($category_slug = null, $news_id = null) {
        $Ad = array();          /** @var array - tablica kodów reklam */
        if (empty($category_slug) && empty($news_id)) {
            $Ad['code1'] = Configure::read('Ad.Blog_code');
            $Ad['code2'] = Configure::read('Ad.Blog_code2');
        } elseif (!empty($news_id)) {
            $news = $this->News->find('first', array('conditions' => array('News.id' => $news_id), 'recursive' => 1));
            if (!empty($news['News']['ad_code'])) {
                $Ad['code1'] = $news['News']['ad_code'];
            } elseif (!empty($news['NewsCategory']['ad_code'])) {
                $Ad['code1'] = $news['NewsCategory']['ad_code'];
            } else {
                $Ad['code1'] = Configure::read('Ad.Blog_code');
            }
            if (!empty($news['News']['ad_code2'])) {
                $Ad['code2'] = $news['News']['ad_code2'];
            } elseif (!empty($news['NewsCategory']['ad_code2'])) {
                $Ad['code2'] = $news['NewsCategory']['ad_code2'];
            } else {
                $Ad['code2'] = Configure::read('Ad.Blog_code2');
            }
        }
        else { 
            $newsCategoriesId = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.id')
            ));
            $currentCategory = $this->News->NewsCategory->find('first', array('conditions' => array('NewsCategory.id' => $newsCategoriesId[$category_slug])));
            if (empty($currentCategory['NewsCategory']['ad_code'])) {
                $Ad['code1'] = Configure::read('Ad.Blog_code');
            } else {
                $Ad['code1'] = $currentCategory['NewsCategory']['ad_code'];
            }
            if (empty($currentCategory['NewsCategory']['ad_code2'])) {
                $Ad['code2'] = Configure::read('Ad.Blog_code2');
            } else {
                $Ad['code2'] = $currentCategory['NewsCategory']['ad_code2'];
            }
        }
        
        return $Ad;
    }   

    public function populars_promoted() {
        $this->layout = false;
        $this->loadModel('StaticProduct.Product');
        $this->helpers[] = 'FebTime';
        $this->helpers[] = 'Fancybox.Fancybox';
        $this->helpers[] = 'Time';
        $this->helpers[] = 'Number';
        $this->Product->bindPromotion(false);
        $popularProducts = $this->Product->getPopularProductsByHit();

        $params3['conditions']['Product.on_blog'] = 1;
        $params3['order'] = 'RAND()';
        $params3['limit'] = 6;
        $promotedOnBlog = $this->Product->find('all', $params3);

        $this->set(compact('popularProducts', 'promotedOnBlog'));
        
        if (empty($this->disable_shop)) {
            $this->render();
        }
        else {
            $this->autoRender = false;
        }
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function index($category_slug = null) {
        $this->layout = 'blog';
        //debug($category_slug);
        $this->loadModel('StaticProduct.Product');
        $this->helpers[] = 'FebTime';
        $this->helpers[] = 'Fancybox.Fancybox';
        $this->helpers[] = 'Time';
        $this->helpers[] = 'Number';
        $this->News->NewsCategory->locale = Configure::read('Config.languages');
        $this->News->NewsCategory->bindTranslation(array('name' => 'translateDisplay'));
        $newsCategories = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.name'),
            'conditions' => array('NewsCategory.is_promoted' => 1),
        ));
        $newsCategoriesId = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.id')
        ));
        
//        $wrongNews = $this->News->find('list', array(
//            'recursive' => -1,
//            'conditions' => array('News.content' => ''),
////            'fields' => array('News.id', 'News.tiny_content', 'News.content')
//            'fields' => array('News.id', 'News.title')
//        ));
        
        if (!empty($category_slug)) {
//            debug($category_slug);
            $slug = explode(':', $category_slug);
            //debug($slug);
            if(count($slug) == 1) {
                $currentCategory = $this->News->NewsCategory->find('first', array('conditions' => array('NewsCategory.id' => $newsCategoriesId[$category_slug])));
                $params['conditions']['News.news_category_id'] = $id = $this->News->NewsCategory->getIdBySlug($category_slug);
            } elseif (count($slug) == 2 && $slug[0] == 'author') {
                //$params = $this->News->filterParams(array('News' => array($slug[0] => $slug[1])));
                $params['conditions']['News.user_id'] = $slug[1];
            }
        }
        
        
        $this->filters = array(
            'News.year' => array('param_name' => "y", 'default' => ''),
            'News.month' => array('param_name' => "m", 'default' => ''),
            'News.author' => array('param_name' => "author", 'default' => '')
        );
        $filtersParams = $this->Filtering->getParams();
        if (!empty($this->request->data)) {
            $params = $this->News->filterParams($this->request->data);
        }
        $this->set('filtersSettings', $this->filters);

        $params['conditions']['News.blog'] = 1;
        $params['conditions']['News.is_published'] = 1;
        $params['limit'] = 10;
        $params['recursive'] = 1;
        $params['order'] = 'News.date DESC';
        
        $this->News->hasMany['Comment']['conditions'] = array('Comment.active' => 1);
        
        $this->paginate = $params;
        $news = $this->paginate();

        $Ad = array();
        if (empty($category_slug)) {
            $Ad['code1'] = Configure::read('Ad.Blog_code');
            $Ad['code2'] = Configure::read('Ad.Blog_code2');
        } else {
            if (empty($currentCategory['NewsCategory']['ad_code'])) {
                $Ad['code1'] = Configure::read('Ad.Blog_code');
            } else {
                $Ad['code1'] = $currentCategory['NewsCategory']['ad_code'];
            }
            if (empty($currentCategory['NewsCategory']['ad_code2'])) {
                $Ad['code2'] = Configure::read('Ad.Blog_code2');
            } else {
                $Ad['code2'] = $currentCategory['NewsCategory']['ad_code2'];
            }
        }
        $this->set(compact('news', 'newsCategories', 'popularProducts', 'currentCategory', 'Ad', 'newsCategoriesId', 'category_slug'));
    }
    public function author($author = null) {
        $this->layout = 'blog';
        //debug($category_slug);
        $this->loadModel('StaticProduct.Product');
        $this->helpers[] = 'FebTime';
        $this->helpers[] = 'Fancybox.Fancybox';
        $this->helpers[] = 'Time';
        $this->helpers[] = 'Number';
        $this->News->NewsCategory->locale = Configure::read('Config.languages');
        $this->News->NewsCategory->bindTranslation(array('name' => 'translateDisplay'));
        $newsCategories = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.name'),
            'conditions' => array('NewsCategory.is_promoted' => 1),
        ));
        $newsCategoriesId = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.id')
        ));
        
        $params['conditions']['News.blog'] = 1;
        $params['conditions']['News.is_published'] = 1;
        $params['conditions']['News.user_id'] = $author;
        $params['limit'] = 10;
        $params['recursive'] = 1;
        $params['order'] = 'News.date DESC';
        $this->paginate = $params;
        $news = $this->paginate();

        $Ad = array();
        if (empty($category_slug)) {
            $Ad['code1'] = Configure::read('Ad.Blog_code');
            $Ad['code2'] = Configure::read('Ad.Blog_code2');
        } else {
            if (empty($currentCategory['NewsCategory']['ad_code'])) {
                $Ad['code1'] = Configure::read('Ad.Blog_code');
            } else {
                $Ad['code1'] = $currentCategory['NewsCategory']['ad_code'];
            }
            if (empty($currentCategory['NewsCategory']['ad_code2'])) {
                $Ad['code2'] = Configure::read('Ad.Blog_code2');
            } else {
                $Ad['code2'] = $currentCategory['NewsCategory']['ad_code2'];
            }
        }
        $this->set(compact('news', 'newsCategories', 'currentCategory', 'Ad', 'newsCategoriesId', 'category_slug'));
        $this->render('index');
    }

    public function blog($slug = null) {
        $this->helpers[] = 'FebTime';
        $this->helpers[] = 'Fancybox.Fancybox';
        $this->News->recursive = 0;
        $params['limit'] = 5;
        $params['conditions'] = array('News.blog' => 1);
        $params['order'] = array('News.date' => 'desc');
        $this->paginate = array();
        $this->paginate = $params;
        $blog = $this->paginate();


//        if(!$this->request->isAjax){
//            $this->redirect(array('action'=>'view',$news[0]['News']['slug']));
//        }
        $this->set(compact('blog'));
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function view($slug = null) {
        $this->loadModel('StaticProduct.Product');
        $this->helpers[] = 'Fancybox.Fancybox';
        $this->helpers[] = 'Time';
        $this->helpers[] = 'Number';
        $this->News->NewsCategory->locale = Configure::read('Config.languages');
        $this->News->NewsCategory->bindTranslation(array('name' => 'translateDisplay'));
        $newsCategories = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.name'),
            'conditions' => array('NewsCategory.is_promoted' => 1)
        ));
        $newsCategoriesId = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.id')
        ));
        //debug($newsCategoriesId);
        //$slug = $this->News->isSlug($slug);
        if (!$slug) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
//        if (!empty($slug['error'])) {
//            $this->redirect(array($slug['slug']), $slug['error']);
//        }
        
        $this->News->hasMany['Comment']['conditions'] = array('Comment.active' => 1);
        $news = $this->News->find('first', array('conditions' => array('News.slug' => $slug), 'recursive' => 1));
        $news_id = $news['News']['id'];
        $newsParam['conditions']['Comment.news_id'] = $news_id;
        $newsParam['conditions']['Comment.active'] = 1;
        $newsParam['order'] = array('Comment.created DESC');
        $newsParam['recursive'] = -1;
        $newsParam['limit'] = 20;
//        debug($news);
        $category = $this->News->NewsCategory->find('first',array('conditions'=>array(
            'NewsCategory.id'=>$news['News']['news_category_id']
        ),'recursive'=>-1));
//        debug($category);
        //$this->News->Comment->paginate = $ newsParam;
        //$newsComments = $this->paginate();
        
        
        $this->loadModel('Comment.Comment');
        $newsComments = $this->Comment->find('all', $newsParam);

//        debug($news);
        //debug($newsComments);
        if (empty($news)) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
//        $params1['conditions']['News.date >='] = date('Y') . '-01-01 00:00:00';
//        $params1['conditions']['News.date <='] = date('Y') . '-12-31 23:59:59';
//        $params1['conditions']['News.blog'] = '1';
//        $params1['group'] = 'month(News.date)';
//        $params1['order'] = 'month DESC';
//        $params1['recursive'] = -1;
//        $params1['fields'] = array('count(News.id) as count', 'month(News.date) as month');
//        $newsByMonths = $this->News->find('all', $params1);
//        $newsByMonths = Set::combine($newsByMonths, '{n}.0.month', '{n}.0');
//
//        $params2['conditions']['News.blog'] = '1';
//        $params2['group'] = 'year(News.date)';
//        $params2['order'] = 'year DESC';
//        $params2['recursive'] = -1;
//        $params2['fields'] = array('count(News.id) as count', 'year(News.date) as year');
//        $newsByYears = $this->News->find('all', $params2);
//        $newsByYears = Set::combine($newsByYears, '{n}.0.year', '{n}.0');
//        $months = $this->getMonths();

        //$newsCategories = $this->NewsCategory->find('all');
        //debug($newsCategories);
        if (!empty($this->data)) {
            //debug($this->data);
            $this->_add_comment($slug);
        }
        //$popularProducts = $this->Product->getPopularProducts();
        $popularProducts = $this->Product->getPopularProductsByHit();
        //$news = $this->News->read(null, $slug['id']);
        //debug($news);

        $users = $this->News->User->find('all');
        $users = Set::combine($users, '{n}.User.id', '{n}');

        $Ad = array();
        if (!empty($news['News']['ad_code'])) {
            $Ad['code1'] = $news['News']['ad_code'];
        } elseif (!empty($news['NewsCategory']['ad_code'])) {
            $Ad['code1'] = $news['NewsCategory']['ad_code'];
        } else {
            $Ad['code1'] = Configure::read('Ad.Blog_code');
        }
        if (!empty($news['News']['ad_code2'])) {
            $Ad['code2'] = $news['News']['ad_code2'];
        } elseif (!empty($news['NewsCategory']['ad_code2'])) {
            $Ad['code2'] = $news['NewsCategory']['ad_code2'];
        } else {
            $Ad['code2'] = Configure::read('Ad.Blog_code2');
        }
        
        $current_news_id = $news['News']['id'];

//        debug($users);
//        debug($news);
        // debug($newsCategories);
        $this->set(compact('popularProducts', 'newsByYears', 'newsByMonths', 'months', 'news', 'newsCategories', 'users', 'newsComments', 'Ad', 'newsCategoriesId','category','current_news_id'));
        
//        // MJ: Skrypt jednorazowego użycia by usunąć frazę ze wszystkim newsów. Zostawiam, może się przyda ;)
//        set_time_limit(500);
//        $all_news = $this->News->find('all', array(
//            'recursive' => -1,
//            'fields' => array('News.id', 'News.content', 'News.tiny_content')
//        ));
//        foreach($all_news as &$news) {
//            $news['News']['tiny_content'] = str_replace('font-size: small;', '', $news['News']['tiny_content']);
//            $news['News']['content'] = str_replace('font-size: small;', '', $news['News']['content']);
//        }
//        $this->News->saveAll($all_news);
    }

    function _add_comment($slug = null) {
        if (!empty($this->data)) {
            $this->News->Comment->set($this->data);
            if ($this->News->Comment->save($this->data)) {
                $this->Session->setFlash(__d('front', 'Komentarz został zapisany i oczekuje na weryfikację.'));
                $this->data = null;
                $this->redirect(array('type' => 'blog', 'plugin' => 'news', 'controller' => 'news', 'action' => 'view', $slug));
            } else {
                $this->Session->setFlash(__d('front', 'Komentarz nie został zapisany. Proszę sprawdzić formularz i spróbować ponownie.'));
            }
        }
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {
        $this->layout = 'admin';
        $this->helpers[] = 'FebTime';
        $this->News->recursive = 1;
        $this->News->locale = Configure::read('Config.languages');

//        $this->set('news', $this->paginate());
//        $news_categories = $this->News->NewsCategory->find('list');
//        $this->set(compact('news_categories'));
        
        $news_categories = $this->News->NewsCategory->find('list');
        
        $this->filters = array(
            //Nazwa
            'News.title' => array('param_name' => 'title', 'default' => '', 'form' => array('label' => __d('cms', 'Tytuł'))),
            'News.news_category_id' => array('param_name' => 'category', 'default' => '', 'form' => array('label' => __d('cms', 'Kategoria'), 'empty' => __d('cms', 'Wybierz'), 'options' => $news_categories)),
            'News.created_from' => array('param_fname' => 'created_from', 'default' => '', 'form' =>
                array('label' => __d('cms', 'Data utworzenia, od'),)),
            'News.created_to' => array('param_name' => 'created_to', 'default' => '', 'form' =>
                array('label' => __d('cms', 'Data utworzenia, do'))),
            'News.date_from' => array('param_name' => 'date_from', 'default' => '', 'form' =>
                array('label' => __d('cms', 'Data wpisu, od'),)),
            'News.date_to' => array('param_name' => 'date_to', 'default' => '', 'form' =>
                array('label' => __d('cms', 'Data wpisu, do'))),
        );
        $this->set('filtersSettings', $this->filters);
        $filtersParams = $this->Filtering->getParams();
        $params = $this->News->cmsfilterParams($this->request->data);
                
        $this->paginate = $params;
        $news = $this->paginate();     
        
        $this->set(compact('filtersParams', 'news_categories', 'news'));
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->layout = 'admin';
        $this->News->id = $id;
        if (!$this->News->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('news', $this->News->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        $this->layout = 'admin';
        $this->helpers[] = 'FebTinyMce';
        if ($this->request->is('post')) {
            $this->request->data['News']['user_id'] = $this->Session->read('Auth.User.id');
            if (empty($this->request->data['News']['date'])) {
                $this->request->data['News']['date'] = date('Y-m-d H:i:s');
            }
            $this->News->create();
            if ($this->News->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        $news_categories = $this->News->NewsCategory->find('list', array(
            'order' => 'NewsCategory.name ASC'
        ));
        $this->set(compact('news_categories'));
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->layout = 'admin';
        $this->helpers[] = 'FebTinyMce4';
        $this->News->id = $id;
//        debug($this->News->read(null, $id));
        if (!$this->News->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['News']['user_id'] = $this->Session->read('Auth.User.id');
            if ($this->News->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->News->locale = Configure::read('Config.languages');
            $this->request->data = $this->News->read(null, $id);
        }
        $news_categories = $this->News->NewsCategory->find('list', array(
            'order' => 'NewsCategory.name ASC'
        ));
        $this->set(compact('news_categories'));
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    function admin_delete($id = null, $all = null) {
        $this->FebI18n->delete($id, $all);
        $this->redirect(array('action' => 'index'), null, true);
    }

    /**
     * Akcja do podpowiadaina danych z formularza
     * 
     * @param type $term
     * @throws MethodNotAllowedException 
     */
    function admin_autocomplete($term = null) {
        $this->layout = 'ajax';
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $params = array();
        $params['fields'] = array('title');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['News.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->News->recursive = -1;
        $params['conditions']["News.title LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->News->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

    function getMonths() {
        $months = array();
        $months['1'] = __d('front', 'Styczeń');
        $months['2'] = __d('front', 'Luty');
        $months['3'] = __d('front', 'Marzec');
        $months['4'] = __d('front', 'Kwiecień');
        $months['5'] = __d('front', 'Maj');
        $months['6'] = __d('front', 'Czerwiec');
        $months['7'] = __d('front', 'Lipiec');
        $months['8'] = __d('front', 'Sierpień');
        $months['9'] = __d('front', 'Wrzesień');
        $months['10'] = __d('front', 'Październik');
        $months['11'] = __d('front', 'Listopad');
        $months['12'] = __d('front', 'Grudzień');
        return $months;
    }

    /**
     * Funkcja wyszukuje newsy w blogu
     */
    function search_blog($search_text = null) {  
        if (empty($search_text) && !empty($this->request->data['Search']['text'])) {
            $this->request->data['Search']['text'] = str_replace('.', '%34', $this->request->data['Search']['text']);
            $this->redirect(array('action' => 'search_blog', $this->request->data['Search']['text']));
        }
        $this->loadModel('StaticProduct.Product');
        $this->layout = 'blog';
        $this->helpers[] = 'Time';
        $this->helpers[] = 'Number';

        $this->News->NewsCategory->locale = Configure::read('Config.languages');
        $this->News->NewsCategory->bindTranslation(array('name' => 'translateDisplay'));
        $newsCategories = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.name'),
            'conditions' => array('NewsCategory.is_promoted' => 1)
        ));
        $newsCategoriesId = $this->News->NewsCategory->find('list', array(
            'fields' => array('NewsCategory.slug', 'NewsCategory.id')
        ));
        if (!empty($category_slug)) {
            $currentCategory = $this->News->NewsCategory->find('first', array('conditions' => array('NewsCategory.id' => $newsCategoriesId[$category_slug])));
        }


        $params1['conditions']['News.date >='] = date('Y') . '-01-01 00:00:00';
        $params1['conditions']['News.date <='] = date('Y') . '-12-31 23:59:59';
        $params1['conditions']['News.blog'] = '1';
        $params1['group'] = 'month(News.date)';
        $params1['order'] = 'month DESC';
        $params1['recursive'] = -1;
        $params1['fields'] = array('count(News.id) as count', 'month(News.date) as month');
        $newsByMonths = $this->News->find('all', $params1);
        $newsByMonths = Set::combine($newsByMonths, '{n}.0.month', '{n}.0');

        $params2['conditions']['News.blog'] = '1';
        $params2['group'] = 'year(News.date)';
        $params2['order'] = 'year DESC';
        $params2['recursive'] = -1;
        $params2['fields'] = array('count(News.id) as count', 'year(News.date) as year');
        $newsByYears = $this->News->find('all', $params2);
        $newsByYears = Set::combine($newsByYears, '{n}.0.year', '{n}.0');
        $months = $this->getMonths();
        //$popularProducts = $this->Product->getPopularProducts();
        $popularProducts = $this->Product->getPopularProductsByHit();
        //debug($popularProducts);
        $Ad = array();
        if (empty($category_slug)) {
            $Ad['code1'] = Configure::read('Ad.Blog_code');
            $Ad['code2'] = Configure::read('Ad.Blog_code2');
        } else {
            if (empty($currentCategory['NewsCategory']['ad_code'])) {
                $Ad['code1'] = Configure::read('Ad.Blog_code');
            } else {
                $Ad['code1'] = $currentCategory['NewsCategory']['ad_code'];
            }
            if (empty($currentCategory['NewsCategory']['ad_code2'])) {
                $Ad['code2'] = Configure::read('Ad.Blog_code2');
            } else {
                $Ad['code2'] = $currentCategory['NewsCategory']['ad_code2'];
            }
        }
        $this->set(compact('news', 'newsCategories', 'newsByMonths', 'newsByYears', 'months', 'popularProducts', 'currentCategory', 'Ad', 'newsCategoriesId'));


        if (!empty($search_text)) {
            $search_text = str_replace('%34', '.', $search_text);
            $this->request->data['Search']['text'] = $search_text;
        }
        if (!empty($this->request->data['Search']['text'])) {
            $words = explode(' ', $this->request->data['Search']['text']);
        } else {
            $words = array();
        }
        //debug($words);
        $params['limit'] = 10;
        //$params['fields'] = array('DISTINCT *');

        foreach ($words as $word) {
            $params['conditions']['OR'][0]['AND'][]['News.title LIKE'] = '%' . $word . '%';
            $params['conditions']['OR'][1]['AND'][]['News.tiny_content LIKE'] = '%' . $word . '%';
            $params['conditions']['OR'][2]['AND'][]['News.content LIKE'] = '%' . $word . '%';
        }
        $this->paginate = $params;
        $this->set('news', $this->paginate());

        $this->render('News/index');
    }

    /**
     * Funckcja konwertuje wszystkie slugi w modelu News z cyrylicy na polskie znaki
     */
    function setup_slug() {
        $newsy = $this->News->find('all');
        //debug(count($newsy));
        $ok = 0;
        $fail = 0;

        set_time_limit(1000);
        foreach ($newsy as $news) {
            //debug($news);
            $news['News']['slug'] = '';
            //debug($news);
            $news_id = $news['News']['id'];
            $this->News->id = $news_id;
            if ($this->News->save($news)) {
                $ok++;
            } else {
                $fail++;
            }
            echo 'ok:' . $ok . '</br>';
            echo 'fail:' . $fail;
            //break;
        }
        $this->render(false);
    }

    
    function hta() {
       $urls = array('vstrechi/',
'relizyi/',
'podkastyi/',
'krossopediya/',
'lukbuki/',
'tehnologii/',
'sovetyi/',
'stati/',
'blog/',
'futbolki.html',
'krossovki.html',
'kepki.html',
'luchshie-krossovki/',
'zakaz.html',
'reglament.html',
'lacoste.html',
'keds.html',
'magazinyi.html',
'wesc.html',
'kr3w.html',
'carhartt.html',
'nikita.html',
'myachi.html',
'intruz.html',
'shop.html',
'loonatik.html',
'adidas.html',
'druzyam.html',
'dickies.html',
'obuv.html',
'dostavka.html',
'reebok.html',
'neff.html',
'converse.html',
'dc.html',
'dada.html',
'nike.html',
'bench.html',
'partycasino.html',
'zdes.html',
'lrg.html',
'partneram.html',
'oplata.html',
'rush.html',
'etnies.html',
'osiris.html',
'k1x.html',
'billabong.html',
'jordan.html',
'jerk.html',
'dzhinsyi.html',
'otzyivyi.html',
'akademiks.html',
'Page-17.html',
'Page-43.html',
'Page-2.html',
'Page-276.html',
'Page-167.html',
'Page-138.html',
'Page-19.html',
'Page-286.html',
'Page-236.html',
'Page-79.html',
'Page-230.html',
'Page-4.html',
'tag/solebox.html',
'Page-8.html',
'Page-3.html',
'tag/nike.html',
'Page-6.html',
'Page-99.html',
'Page-7.html',
'Page-56.html',
'tag/levis.html',
'Page-15.html',
'tag/reebok.html',
'tag/supreme.html',
'Page-150.html',
'Page-10.html',
'tag/huf.html',
'Page-134.html',
'tag/mishka.html',
'Page-154.html',
'new-era.html',
'Page-185.html',
'poluchit-skidku.html',
'Page-126.html',
'Page-117.html',
'Page-139.html',
'tag/supra.html',
'Page-101.html',
'Page-111.html',
'Page-5.html',
'Page-9.html',
'tag/undftd.html',
'tag/gourmet.html',
'Page-151.html',
'Page-90.html',
'Page-289.html',
'tag/puma.html',
'Page-129.html',
'Page-33.html',
'tag/bodega.html',
'tag/saucony.html',
'tag/stussy.html',
'Page-177.html',
'oborudovanie-streetstylestudio.html',
'crooks-castles.html',
'Page-106.html',
'tag/mache.html',
'Page-102.html',
'golovnyie-uboryi.html',
'tag/converse.html',
'Page-61.html',
'Page-74.html',
'3tazh-minusa.html',
'tag/rocksmith.html',
'Page-46.html',
'Page-143.html',
'wrung-division.html',
'iron-fist.html',
'mitchell-ness.html',
'zoo-york.html',
'king-apparel.html',
'tag/deadline.html',
'ecko-unltd.html',
'tag/bespoke.html',
'tag/carhartt.html',
'tag/parra.html',
'razmeryi-odezhdyi.html',
'tag/undefeated.html',
'busta-grip.html',
'tag/rebel8.html',
'tag/sneakersnstuff.html',
'tag/clarks.html',
'lost-password.html',
'pelle-pelle.html',
'sean-john.html',
'dyse-one.html',
'urban-classics.html',
'nanny-state.html',
'tag/nike-foamposite.html',
'lukbuki/Page-3.html',
'tag/nike-zoom.html',
'relizyi/Page-34.html',
'relizyi/Page-7.html',
'lukbuki/Page-2.html',
'room-recordz-fm.html',
'relizyi/Page-11.html',
'tag/krasnyie-krossovki.html',
'relizyi/Page-46.html',
'relizyi/Page-53.html',
'tag/vans-era.html',
'tag/new-balance.html',
'relizyi/Page-28.html',
'tag/nike-hyperdunk.html',
'relizyi/Page-2.html',
'relizyi/Page-26.html',
'relizyi/Page-35.html',
'tag/the-hundreds.html',
'tag/jeremy-scott.html',
'tag/nike-dunk.html',
'tag/nike-cortez.html',
'krossovki-supra-strike.html',
'tag/krossovki-asics.html',
'tag/krossovki-jordan.html',
'lukbuki/Page-4.html',
'krossovki-nike-eastham.html',
'krossovki-gourmet-rossi.html',
'tag/nike-id.html',
'sovetyi/Page-3.html',
'tag/nike-wmns.html',
'sovetyi/Page-2.html',
'kniga-ot-supra.html',
'tag/nike-free.html',
'tag/adidas-springblade.html',
'relizyi/Page-5.html',
'relizyi/Page-3.html',
'stati/Page-8.html',
'relizyi/Page-94.html',
'tehnologii/Page-2.html',
'krossovki-ewing-focus.html',
'tag/krossovki-adidas.html',
'stati/Page-120.html',
'tag/adidas-gazelle.html',
'karta-sayta-1.html',
'krossovki-nike-lunarspeed.html',
'relizyi/Page-38.html',
'tag/new-era.html',
'relizyi/Page-15.html',
'tag/odd-future.html',
'tag/adidas-crazyquick.html',
'tag/pink-dolphin.html',
'tag/lebron-james.html',
'tag/vans-authentic.html',
'tag/vans-otw.html',
'stati/Page-10.html',
'stati-fake-or-original/',
'tag/krossovki-puma.html',
'tag/under-armour.html',
'stati/Page-30.html',
'relizyi/Page-4.html',
'relizyi/Page-13.html',
'tag/nike-flyknit.html',
'tag/krossovki-reebok.html',
'relizyi/Page-31.html',
'relizyi/Page-22.html',
'tablitsa-razmerov-kepok.html',
'relizyi/Page-21.html',
'tag/stefan-janoski.html',
'tag/adidas-originals.html',
'relizyi/Page-9.html',
'tag/tinker-hatfield.html',
'vstrechi/Page-4.html',
'tag/nike-toki.html',
'tag/adidas-zx.html',
'tag/black-scale.html',
'relizyi/Page-39.html',
'tag/reebok-pump.html',
'lukbuki/Page-5.html',
'relizyi/Page-10.html',
'relizyi/Page-8.html',
'relizyi/Page-6.html',
'stati/Page-19.html',
'relizyi/Page-32.html',
'relizyi/Page-14.html',
'tag/ulichnaya-moda.html',
'krossovki-supra-pistol.html',
'relizyi/Page-18.html',
'tag/nike-sb.html',
'tag/adidas-boost.html',
'relizyi/Page-87.html',
'tag/adidas-skateboarding.html',
'vstrechi/Page-3.html',
'tag/vans-vault.html',
'krossovki-supra-hammer.html',
'relizyi/Page-37.html',
'tag/dc-shoes.html',
'krossovki-adidas-oregon.html',
'krossovki-adidas-springblade.html',
'kedyi-supra-mariner.html',
'tag/beysbolnyie-futbolki.html',
'give-me-face.html',
'tag/nike-hyperflight.html',
'create-customer-account.html',
'tag/50-cent.html',
'kedyi-converse-pc-primo.html',
'hip-hop-zhurnal-slovo.html',
'kollektsiya-nike-football-fc247.html',
'krossovki-reebok-classic-trail.html',
'tag/nike-kd-v.html',
'prevyu-kollektsii-huf-footwear.html',
'krossovki-puma-ely-future.html',
'tag/nike-free-trainer.html',
'krossovki-adidas-slvr-primeknit.html',
'tag/vans-old-skool.html',
'nabor-nike-running-breathe.html',
'krossovki-adidas-skateboarding-pitch.html',
'krossovki-supra-donavyn-break.html',
'krossovki-nike-pink-ribbon.html',
'luchshie-krossovki/Page-35.html',
'kepki-mishka-leto-2012.html',
'kak-vyivesti-pyatna-travyi.html',
'kedyi-vans-madero-twill.html',
'krossovki-nike-rosherun-fb.html',
'krossovki-adidas-originals-country.html',
'krossovki-nike-air-pacer.html',
'luchshie-krossovki/Page-45.html',
'sliponyi-vans-lp-slip.html',
'spetsialnoe-izdanie-adidas-springblade.html',
'prilozhenie-ot-nike-sb.html',
'tag/nike-kobe-8.html',
'krossovki-adidas-honey-desert.html',
'krossovki-adidas-skateboarding-ciero.html',
'prazdnichnaya-kollektsiya-dqm-2012.html',
'kollabratsiya-supreme-x-timberland.html',
'audi-e-bike-worthersee.html',
'krossovki-puma-suede-black.html',
'krossovki-supra-falcon-cheetah.html',
'luchshie-krossovki/Page-52.html',
'onlayn-studiya-zvukokorrektsii-streetstyle.html',
'krossovki-gourmet-2013-prevyu.html',
'krossovki-supra-spectre-griffin.html',
'luchshie-krossovki/Page-4.html',
'avgustovskiy-reliz-adidas-springblade.html',
'krossovki-supra-vaider-lc.html',
'raspakovka-air-jordan-xx8.html',
'odezhda-durkl-leto-2012.html',
'kamuflyazhnaya-kurtka-maiden-noir.html',
'krossovki-adidas-unveils-boost.html',
'luchshie-krossovki/Page-33.html',
'luchshie-krossovki/Page-3.html',
'odezhda-huf-osen-2012.html',
'kedyi-losers-uneaker-shark.html',
'kollektsiya-nike-n7-2013.html',
'tag/nike-roshe-run.html',
'krossovki-supra-owen-mid.html',
'krossovki-new-balance-ct891.html',
'krossovki-vans-otw-prelow.html',
'krossovki-nike-cortez-zebra.html',
'krossovki-nike-zoom-attero.html',
'krossovki-reebok-classic-jam.html',
'odezhda-rebel8-lookbook-2012.html',
'tag/nike-lunar-blazer.html',
'krossovki-nike-lunar-internationalist.html',
'tag/nike-air-safari.html',
'krossovki-huf-ramondetta-pro.html',
'ryukzak-eastpak-h-krisvanassche.html',
'krossovki-nike-free-flyknit.html',
'kedyi-vans-chima-pro.html',
'krossovki-adidas-originals-beckenbauer.html',
'krossovki-adidas-originals-greenstar.html',
'tag/air-jordan-1.html',
'softak.com.ua-ua.html',
'tag/nike-air-max.html',
'tag/supra-skytop-iii.html',
'tag/converse/Page-1.html',
'tag/vans-half-cab.html',
'tag/new-balance-numeric.html',
'tag/nike-air-revolution.html',
'kedyi-vans-era-leopard.html',
'krossovki-reebok-zig-carbon.html',
'tag/nike-free-run.html',
'tag/nike/Page-1.html',
'tag/nike-air-pegasus.html',
'kedyi-huf-sutter-420.html',
'aprelskie-rastsvetki-supra-stacks.html',
'krossovki-supra-society-bunker.html',
'zhenskie-krossovki-supra-2012.html',
'kedyi-vans-authentic-guate.html',
'krossovki-adidas-skateboarding-seeley.html',
'krossovki-nike-braata-lr.html',
'tag/nike-lebron-x.html',
'krossovki-jordan-flight-luminary.html',
'predstoyaschie-rastsvetki-adidas-crazyquick.html',
'krossovki-new-balance-wp996.html',
'tag/krossovki-nike-blazer.html',
'kak-chistit-zamshevuyu-obuv.html',
'kollabratsiya-liberty-x-vans.html',
'tag/vans-sk8-hi.html',
'tag/nike-air-yeezy.html',
'obuv-obey-wino-canvas.html',
'tag/nike-lebron-9.html',
'skeytshop-nike-sb-civilist.html',
'krossovki-adidas-campus-ftbl.html',
'krossovki-adidas-energy-boost.html',
'tag/nike-kd-vi.html',
'ofitsialnyie-izobrazheniya-adidas-crazyquick.html',
'tag/elite-series-2.html',
'kamuflyazhnyie-krossovki-gourmet-camouflage.html',
'tennisnyie-krossovki-nike-2012.html',
'tag/vans-slip-on.html',
'krossovki-supra-skytop-4.html',
'krossovki-supra-jefferson-pack.html',
'prevyu-reebok-scrimmage-mid.html',
'kontaktyi/yurchenko-roman-aleksandrovich.html',
'tag/vans-chima-pro.html',
'f.s.a.s.html',
'tag/the-blonde-locks.html',
'tag/nike-lunar-montreal.html',
'tag/hall-of-fame.html',
'tag/nike-air-pegasu.html',
'kak-pravilno-ukorotit-dlinu-dzhinsov.html',
'futbolki-mishka-na-leto-2012.html',
'tag/krossovki-jordan/Page-1.html',
'obzor-krossovok-adidas-adipure-basketball.html',
'letnyaya-kollektsiya-odezhdyi-89-lookbook.html',
'avgustovskie-relizyi-nike-free-flyknit.html',
'krossovki-nike-flyknit-racer-prevyu.html',
'nabor-puma-clyde-urb-pack.html',
'kollabratsiya-supra-x-g-shock.html',
'krossovki-vans-otw-bedford-boot.html',
'obzor-krossovok-adidas-adipower-howard.html',
'krossovki-reebok-pump-twilight-zone.html',
'kedyi-vans-era-pop-outsole.html',
'25-luchshih-krossovok-2012-goda.html',
'kollabratsiya-haze-x-huf-mateo.html',
'kedyi-vans-lxvi-secant-2012.html',
'krossovki-converse-pro-leather-zip.html',
'krossovki-nike-lunar-swingtip-ridgerock.html',
'krossovki-nike-lunar-terra-safari.html',
'krossovki-nike-free-sock-racer.html',
'prazdnichnyie-rastsvetki-adidas-skateboarding-busentiz.html',
'krossovki-nike-solarsoft-moccasin-chukka.html',
'nabor-nike-dunk-high-superhero.html',
'krossovki-adidas-skateboarding-americana-vin.html',
'krossovki-nike-classic-cortez-leather.html',
'kollektsiya-adidas-originals-blue-2013.html',
'krossovki-nike-kd-v-n7.html',
'tag/nike-sb/Page-1.html',
'odezhda-undftd-2012-chast-2.html',
'nabor-adidas-collectors-project-pack.html',
'kedyi-vans-authentic-suede-leather.html',
'kedyi-adidas-skateboarding-busenitz-adv.html',
'osenniy-reliz-saucony-shadow-original.html',
'martovskie-rastsvetki-supra-s1w-2013.html',
'krossovki-adidas-originals-gazelle-indoor.html',
'kollabratsiya-ronnie-fieg-i-sebago.html',
'obzor-krossovok-under-armour-juke.html',
'tag/nike-sb-project-ba.html',
'nabor-vans-lxvi-camo-pack.html',
'krossovki-huf-1984-woodland-camo.html',
'krossovki-nike-koston-2-max.html',
'osennie-rastsvetki-supra-vaider-lcs.html',
'kedyi-vans-era-snorkel-blue.html',
'kollektsiya-wiz-khalifa-ot-converse.html',
'krossovki-nike-blazer-low-purple.html',
'krossovki-adidas-supernova-glide-boost.html',
'krossovki-nike-sb-bhm-pack.html',
'kedyi-vans-authentic-tie-dye.html',
'krossovki-nike-roshe-run-split.html',
'krossovki-nike-toki-low-vintage.html',
'krossovki-asics-gel-saga-rudolph.html',
'krossovki-adidas-originals-zx5000-rspn.html',
'krossovki-adidas-skateboarding-busenitz-forest.html',
'kollabratsiya-white-mountaineering-x-saucony.html',
'predstoyaschie-modeli-new-balance-numeric.html',
'krossovki-adidas-artillery-as-mid.html',
'krossovki-vans-otw-bedford-ballistic.html',
'kedyi-vans-old-skool-leopard.html',
'kedyi-vans-california-suedes-pack.html',
'kedyi-vans-era-overspray-pack.html',
'krossovki-nike-sb-lunar-gato.html',
'krossovki-adidas-crazy-fast-runner.html',
'obzor-krossovok-jordan-fly-wade.html',
'krossovki-adidas-originals-zx-850.html',
'krossovki-nike-roshe-run-high.html',
'tag/nike-lunar-force-1.html',
'prevyu-kollektsii-2014-ot-asics.html',
'kedyi-converse-trapasso-pro-ii.html',
'osennyaya-kollektsiya-odezhdyi-stussy-2012.html',
'kollabratsiya-disney-x-vans-vault.html',
'krossovki-nike-lunar-swingtip-cvs.html',
'krossovki-puma-trinomic-trail-2012.html',
'novyie-rastsvetki-nike-roshe-run.html',
'nabor-puma-suede-93-pack.html',
'prevyu-bodega-x-vans-authentic.html',
'nabor-vans-otw-feathers-pack.html',
'krossovki-vans-otw-feather-pack.html',
'kedyi-vans-authentic-snake-pack.html',
'krossovki-adidas-torsion-allegra-infrared.html',
'krossovki-vans-chukka-nordic-pack.html',
'krossovki-converse-kenny-anderson-two.html',
'krossovki-supra-s1w-data-reliza.html',
'kollektsiya-nike-sportswear-monotones-collection.html',
'krossovki-nike-free-5.0.html',
'krossovki-puma-rs-100-animal.html',
'krossovki-nike-lunar-rod-mesh.html',
'krossovki-nike-roshe-run-nm.html',
'krossovki-adidas-rose-3-nightmare.html',
'novyie-rastsvetki-nike-lunar-presto.html',
'krossovki-adidas-originals-nastase-og.html',
'krossovki-puma-trinomic-xt1-plus.html',
'krossovki-asics-gel-lyte-v.html',
'osennie-relizyi-huf-footwear-2013.html',
'otvetyi-na-chasto-zadavaemyie-voprosyi.html',
'kedyi-converse-pro-leather-low.html',
'botinki-reebok-ex-o-fit.html',
'kollektsiya-marvel-comics-x-vans.html',
'kedyi-vans-syndicate-era-pro.html',
'krossovki-nike-cheyenne-2013-og.html',
'kedyi-vans-era-wingtip-2012.html',
'mayskie-rastsvetki-adidas-zx-750.html',
'kedyi-new-balance-numeric-ct891.html',
'yanvarskie-relizyi-brenda-new-balance.html',
'krossovki-air-jordan-xx8-hardwood.html',
'kedyi-huf-choice-teal-brick.html',
'krossovki-nike-wmns-lunar-montreal.html',
'kedyi-vans-syndicate-chima-pro.html',
'vesennie-rastsvetki-vans-otw-alomar.html',
'aprelskie-rastsvetki-nike-solarsoft-moccasin.html',
'mayskie-rastsvetki-reebok-ers-1500.html',
'oktyabrskiy-reliz-new-balance-numeric.html',
'kedyi-vans-lxvi-graph-2012.html',
'krossovki-nike-roshe-run-2012.html',
'kollektsiya-nike-kd-v-n7.html',
'krossovki-adidas-originals-adiease-surf.html',
'krossovki-le-coq-sportif-r1000.html',
'krossovki-puma-archive-lite-low.html',
'kollabratsiya-staple-x-puma-clyde.html',
'krossovki-adidas-originals-phantom-electricity.html',
'predstoyaschie-rastsvetki-nike-hyperdunk-2013.html',
'krossovki-nike-paul-rodriguez-vi.html',
'krossovki-adidas-skateboarding-forum-x.html',
'vsyo-o-krossovkah-jordan-elements.html',
'krossovki-nike-sb-project-ba.html',
'krossovki-reebok-classic-leather-khaki.html',
'krossovki-waysayer-lx-ot-etnies.html',
'data-reliza-nike-lebron-11.html',
'prevyu-adidas-originals-running-2014.html',
'krossovki-nike-sb-kollektsiya-2013.html',
'krossovki-nike-air-odyssey-87.html',
'krossovki-adidas-zx-tr-mid.html',
'krossovki-supra-ellington-red-white.html',
'botinki-nike-acg-manoa-hazelnut.html',
'vesennie-rastsvetki-vans-womens-authentic.html',
'krossovki-nike-air-max-2013.html',
'krossovki-puma-leopard-pack-2013.html',
'raspakovka-nike-lebron-x-cork.html',
'krossovki-nike-street-gato-ac.html',
'krossovki-le-coq-sportif-flash.html',
'kedyi-vans-lxvi-unveiled-2012.html',
'tag/nike-pre-montreal-racer.html',
'krossovki-adidas-crazyquick-oil-spill.html',
'tag/krossovki-adidas/Page-1.html',
'kollektsiya-nike-air-max-glow.html',
'kedyi-nike-sb-highbred-2012.html',
'beysbolnyie-kurtki-ot-brooklyn-circus.html',
'kedyi-vans-era-acid-denim.html',
'huf-footwear-kollektsiya-vesna-2013.html',
'krossovki-nike-air-max-cage.html',
'top-sayderyi-vans-surf-chauffette.html',
'kedyi-vans-rowley-spv-tsena.html',
'krossovki-vans-cab-lite-black.html',
'yanvarskie-rastsvetki-nike-zoom-hyperdisruptor.html',
'data-reliza-nike-kd-vi.html',
'krossovki-nike-air-max-2014.html',
'ofitsialnyiy-anons-nike-free-flyknit.html',
'kedyi-converse-pro-leather-vac.html',
'krossovki-reebok-aztec-flex-racer.html',
'krossovki-adidas-primeknit-2.0.html',
'krossovki-under-armour-speedform-rc.html',
'vesna-2014-new-balance-577.html',
'krossovki-nike-air-180-camo.html',
'iyulskie-rastsvetki-new-balance-576.html',
'krossovki-gourmet-cinque-2-mp.html',
'krossovki-vans-rowley-pro-2013.html',
'yanvarskaya-rastsvetka-nike-lunareclipse-3.html',
'kedyi-vans-era-59-cl.html',
'krossovki-nike-roshe-run-gs.html',
'kedyi-vans-half-cab-camo.html',
'krossovki-nike-classic-cortez-vntg.html',
'seriya-krossovok-nike-medal-stand-2012.html',
'nabor-undftd-x-nike-bringback-pack.html',
'krossovki-nike-lunarspeed-grand-purple-black.html',
'krossovki-nike-roshe-run-summer-safari.html',
'predstoyaschie-rastsvetki-nike-lunar-flyknit-chukka.html',
'nabor-new-balance-574-alpine-pack.html',
'red-bull-skeyt-park-shustera-video.html',
'sentyabrskiy-reliz-adidas-originals-zx-700.html',
'krossovki-nike-zoom-stefan-janoski-floral.html',
'krossovki-new-balance-hs77-dragon-boat-festival.html',
'data-reliza-supreme-x-nike-flyknit-lunar1.html',
'nabor-nike-stefan-janoski-mid-wool-fleece.html',
'krossovki-weatherman-nike-air-force-1-low.html',
'installyatsiya-nike-air-force-1-pivot-point.html',
'krossovki-nike-air-max-1-volt-black.html',
'krossovki-nike-roshe-run-mid-city-pack.html',
'krossovki-nike-tennis-classic-ac-j1-league.html',
'kollabratsiya-xlarge-x-vans-chukka-duck-camo.html',
'krossovki-supra-owen-year-of-the-snake.html',
'tizer-spot-x-nike-sb-dunk-low.html',
'film-o-kompanii-vans-since-66-video.html',
'krossovki-nike-hyperdunk-+-na-nike-id.html',
'zhenskaya-odezhda-crooks-castles-na-leto-2012-lukbuk.html',
'novyie-rastsvetki-nikeid-dlya-nike-koston-sb-1.html',
'tizer-kollabratsii-stash-x-reebok-classic-city-collection.html',
'kastomizatsiya-nike-lebron-x-the-flash-ot-mache.html',
'krossovki-nike-air-force-1-downtown-black-leather.html',
'krossovki-nike-sb-dunk-high-vanilla-suede-2013.html',
'krossovki-nike-air-180-grey-blue-pink-safari.html',
'krossovki-nike-air-force-1-low-black-grey-volt.html',
'kastomizatsiya-nike-air-foamposite-one-420-ot-gourmet-kickz.html',
'kollabratsiya-opening-ceremony-x-adidas-originals-rod-laver-vintage-high.html',
'krossovki-nike-lunar-force-1-reflect-gold-suede-reflective-silver.html',
'data-reliza-ronnie-fieg-x-asics-gel-lyte-v-volcano.html',
'krossovki-nike-roshe-run-challenge-red-dark-pewter-total-crimson.html',
'kollabratsiya-doernbecher-x-nike-zoom-stefan-janoski-ot-ross-hathaway.html',
'informatsiya-o-kollabratsii-carhartt-wip-x-vans-syndicate-era-tab-s.html',
'kollektsiya-ghost-hunter-ot-dwight-howard-x-adidas-x-foot-locker.html',
'Page-277.html',
'nabor-vans-otw-prescott-lines-pack.html',
'Page-274.html',
'nabor-nike-lebron-x-championship-pack.html',
'krossovki-nike-sb-stefan-janoski-tiger-stripe.html',
'Page-288.html',
'Page-25.html',
'krossovki-nike-air-max-1-premium-gamma-blue-brave-blue-atomic-pink.html',
'krossovki-franklin-and-marshall-x-puma-clyde.html',
'kedyi-cncpts-x-vans-syndicate-sk8-hi-combat-zone.html',
'Page-273.html',
'krossovki-nike-eric-koston-2-armory-navy-laser-orange.html',
'krossovki-nike-lunaracer+-3-volt.html',
'kastomizatsiya-nike-roshe-run-sunset-ot-cdk.html',
'krossovki-adidas-skateboarding-gonz-pro.html',
'zhenskie-rastsvetki-supra-owen.html',
'avgustovskiy-reliz-nike-sb-2013.html',
'prevyu-2014-nike-lunar-flyknit-chukka.html',
'kollabratsiya-uprise-x-nike-sb-dunk-high.html',
'krossovki-adidas-originals-ts-lite-amr-trophy-hunter.html',
'pow.html',
'osennyaya-kollektsiya-odezhdyi-ot-brenda-play-cloths-1-chast.html',
'krossovki-nike-air-force-1-downtown-hi-hologram.html',
'kak-razvivalas-tehnologiya-nike-air-nemnogo-podrobnostey.html',
'krossovki-nike-sb-stefan-janoski-digi-floral.html',
'prevyu-kollabratsii-supreme-x-vans-chukka-boot-floral.html',
'Page-228.html',
'bruno-g.html',
'ofitsialnyiy-anons-nike-free-hyperfeel.html',
'iyunskiy-reliz-adidas-crazy-light-2-low.html',
'krossovki-gourmet-nove-2-lx.html',
'Page-260.html',
'krossovki-air-jordan-v-doernbecher-kak-oni-budut-vyiglyadet.html',
'tizer-kollabratsii-ubiq-x-new-balance.html',
'kollabratsiya-primitive-x-dj-clark-kent-x-nike-sb-dunk-low-112.html',
'krossovki-vans-california-chukka-ca-leopard-camo.html',
'data-reliza-nike-zoom-revis-black-volt.html',
'futbolka-s-printom-air-yeezy-2-chto-za.html',
'Page-113.html',
'kollektsiya-odezhdyi-stussy-vesna-leto-2013-pervyie-postavki.html',
'tizer-sotrudnichestva-dave-white-x-carmelo-anthony-x-jordan-brand.html',
'novyiy-relizyi-ot-billionaire-boys-club.html',
'kollabratsiya-fucking-awesome-x-vans-era.html',
'krossovki-nike-braata-lr-premium-tie-dye.html',
'reklama-cam-cam-dlya-kollektsii-cam-newton-x-under-armour-x-foot-locker.html',
'fevralskie-relizyi-jordan-brand-2013.html',
'kollabratsiya-jason-dill-x-vans-syndicate-derby-wheat.html',
'kollabratsiya-teenage-mutant-ninja-turtles-x-fila-fx-100.html',
'tizer-kollabratsii-solebox-x-saucony-shadow-5000.html',
'krossovki-adidas-originals-azurine-espadrille.html',
'krossovki-nike-lebron-x-red-suede.html',
'kollektsiya-odezhdyi-lrg-life-colors-osen-2012.html',
'Page-283.html',
'13-video-podkast-ot-room-recordz-fm-intervyu-s-maestro-a-sid.html',
'krossovki-nike-koston-express.html',
'data-reliza-nike-kobe-8-all-star.html',
'Page-21.html',
'predstoyaschie-rastsvetki-nike-sb-project-ba.html',
'blud.html',
'kollektsiya-jordan-brand-black-history-month.html',
'kedyi-kiroic-x-vans-kollektsiya-vesna-leto-2013.html',
'krossovki-nike-rosherun-mid-city-pack.html',
'yanvarskie-relizyi-nike-trainer-clean-sweep.html',
'kedyi-taka-hayashi-x-vans-vault-chukka-lx-th-iyul-2012.html',
'predstoyaschie-rastsvetki-nike-vengeance-sd.html',
'krossovki-nike-dunk-free.html',
'kollabratsiya-bodega-x-vans-coming-to-america.html',
'kollabratsiya-blackrainbow-paris-x-puma-r698-pack.html',
'nabor-vans-otw-kitu-print.html',
'Page-55.html',
'Page-249.html',
'krossovki-air-jordan-1-retro-txt.html',
'novyiy-lukbuk-ot-acapulco-gold.html',
'Page-243.html',
'audio-podkast-11-ot-zhurnala-slovo-frantsuzskiy-rep.html',
'botinki-lanvin-python-desert.html',
'Page-171.html',
'streetstylestudio-onlayn-studiya-zvukokorrektsii.html',
'avgustovskiy-reliz-nike-air-safari.html',
'kedyi-vans-sk8-hi-island-print.html',
'nabor-undefeated-x-nike-bring-back-2003.html',
'kollabratsiya-chet-childress-x-nike-zoom-verona.html',
'populyarnyie-brendyi.html',
'letnyaya-kollektsiya-obuvi-huf-2013.html',
'chehol-dlya-iphone-5-ot-whiz-x-gizmobies.html',
'futbolka-end-ot-brenda-fuct.html',
'nabor-gourmet-cinque-2-tx-forest-camo.html',
'hip-hop-zhurnal-slovo-predstavil-svoy-6-audio-podkast.html',
'new-balance-zapuskaet-novuyu-lineyku-3d-printed-shoes.html',
'letnyaya-odezhda-varsity-black-lukbuk-2012.html',
'lukbuk-zhenskoy-kollektsii-supra.html',
'svechka-ot-stussy-x-baxter-of-california.html',
'tizer-fevralskoy-kollabratsii-undftd-x-nike.html',
'Page-70.html',
'nabor-gourmet-cork-pack-osen-2013.html',
'krossovki-nike-sb-iyulskiy-reliz.html',
'semplyi-slonovogo-printa-na-nike-air-force-1-premium-id.html',
'kollektsiya-nike-hyperflight-superhero-collection.html',
'innovatsii-v-magazinah-nike.html',
'metodyi-hraneniya-obuvi-ot-ikea.html',
'hudi-kris-van-assch-iz-letney-kollektsii-2013.html',
'krossovki-air-jordan-ix-motorboat-jones.html',
'kedyi-vans-otw-ludlow-camo-rock.html',
'mishka-2012-letniy-lukbuk.html',
'Page-287.html',
'kedyi-play-cloths-x-pro-keds-royal-cvo-2012.html',
'predvaritelnyiy-prosmotr-osenney-kollektsii-2013-ot-vans-california.html',
'krossovki-aunt-pearl-nike-kd-v.html',
'dekabrskie-rastsvetki-nike-toki-premium.html',
'kollabratsiya-blood-wizard-x-adidas-skateboarding-adi-ease.html',
'govoryaschie-krossovki-ot-google-%E2%80%93-the-talking-shoe.html',
'kontsept-upakovki-nike-air.html',
'futbolki-stussy-x-joey-badass-and-the-progressive-era.html',
'novyie-vans-sk85ive2-half-cab-2012-prezentatsiya.html',
'Page-232.html',
'krossovki-reebok-berlin-chukka.html',
'novyiy-reliz-holiday-2012-ot-tantum.html',
'kollabratsiya-hello-kitty-x-vans-authentic.html',
);
        
    set_time_limit(900);
       foreach($urls as $key => $url) {
            $ch = curl_init($_SERVER['HTTP_HOST'].'/'.$url);
//            $ch = curl_init($_SERVER['HTTP_HOST'].'/'.'kedyi-vans-otw-ludlow-camo-rock.html');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
            @curl_setopt($ch, CURLOPT_HEADER  , true);  // we want headers
            @curl_setopt($ch, CURLOPT_NOBODY  , true);  // we don't need body
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if ($httpcode == '404') {
                echo $url . ' BAD';
            }
            else {
                echo $url . ' GOOD';
            }
            echo "<br/>";            
//            if ($key > 5)  exit;
       }
       exit;
    }
    
}
