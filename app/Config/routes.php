<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
$languages = array();
$languages = implode('|', $languages);
$type = array('shop', 'blog','studio');
$type = implode('|', $type);
$plugins = implode('|', array('news', 'static_product', 'commerce', 'user', 'brand', 'newsletter', 'dynamic_elements', 'page', 'studio'));

Router::parseExtensions();

Router::connectNamed(array('lang'), array('default' => true));

Router::connect('/grayscale/*', array('controller' => 'images', 'action' => 'singleFile', 'plugin' => 'Image'));
Router::connect('/js/tiny_mce4/js/tinymce/plugins/filemanager/*', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'ajaxfilemanager'));
//Router::connect('/blog', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'display', 'index'));
Router::connect('/', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'display', 'index'));
//Router::connect('/:lang', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'display', 'index'), array('lang' => $languages));

Router::connect('/integratory-xml/:action/*', array('plugin' => 'PriceComparisionXml', 'controller' => 'PricesComparisionXmls'));


/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
//Router::connect('/page/*', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'display'));

Router::connect('/:lang/admin', array('plugin' => 'panel', 'controller' => 'panel', 'action' => 'index', 'admin' => true), array('lang' => $languages));
Router::connect('/admin', array('plugin' => 'panel', 'controller' => 'panel', 'action' => 'index', 'admin' => 'admin'));

//Router::connect('/blog/*', array('plugin' => 'news', 'controller' => 'news', 'action' => 'index'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

Router::connect('/:type/page/pages/view/*', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'view'), array('type' => $type));
Router::connect('/:type/search', array('plugin' => 'news', 'controller' => 'news', 'action' => 'search_blog'), array('type' => 'blog'));
Router::connect('/:type/page/*', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'view'), array('type' => $type));
Router::connect('/:type/article/*', array('plugin' => 'news', 'controller' => 'news', 'action'=>'view','type' => 'blog'), array('type' => 'blog'));
Router::connect('/:type/author/*', array('plugin' => 'news', 'controller' => 'news', 'action'=>'author','type' => 'blog'), array('type' => 'blog'));
Router::connect('/:type/*', array('plugin' => 'news', 'controller' => 'news', 'action'=>'index'), array('type' => 'blog'));
Router::connect('/:type', array('plugin' => 'news', 'controller' => 'news', 'action' => 'index'), array('type' => 'blog'));
Router::connect('/blog_search/*', array('plugin' => 'news', 'controller' => 'news', 'action' => 'search_blog'), array('type' => 'blog'));
//Router::connect('/:type/*', array('plugin' => 'page', 'controller' => 'pages', 'action'=> 'display', 'studio_index'), array('type' => 'studio'));
Router::connect('/:type', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'display', 'studio_index'), array('type' => 'studio'));
//Router::connect('/:type', array('plugin' => 'news', 'controller' => 'news', 'action' => 'index'), array('type' => 'studio'));
Router::connect('/:type', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'display', 'index'), array('type' => $type));
Router::connect('/:type/search', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'display', 'search'), array('type' => $type));

// Przyjazde linki dla sklepu
Router::connect('/page/*', array('plugin' => 'page', 'controller' => 'pages', 'action' => 'view'), array('type' => $type));
Router::connect('/product/*', array('plugin' => 'static_product', 'controller' => 'products', 'action' => 'view'), array('type' => $type));
Router::connect('/products/*', array('plugin' => 'static_product', 'controller' => 'products_categories', 'action' => 'view'), array('type' => $type));
Router::connect('/brands/*', array('plugin' => 'brand', 'controller' => 'brands', 'action' => 'view'), array('type' => 'blog'));

Router::connect('/:lang/admin/:plugin/:controller/:action/*', array('plugin' => true, 'admin' => true), array('plugin' => $plugins, 'lang' => $languages));
Router::connect('/:lang/:plugin/:controller/:action/*', array(), array('plugin' => $plugins, 'lang' => $languages));
Router::connect('/:type/:plugin/:controller/:action/*', array(), array('plugin' => $plugins, 'type' => $type));

Router::connect('/:lang/admin/:controller/:action/*', array('admin' => true), array('lang' => $languages));
Router::connect('/:lang/admin/:controller/:action/*', array('admin' => 'admin'), array('lang' => $languages));
Router::connect('/:lang/admin/:controller', array('admin' => 1, 'prefix' => 'admin'), array('lang' => $languages));
Router::connect('/:lang/admin/:controller', array('admin' => 'admin', 'prefix' => 'admin'), array('lang' => $languages));

Router::connect('/:lang/:controller/:action/*', array(), array('lang' => $languages));
Router::connect('/:lang/:controller/', array(), array('lang' => $languages));




/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';