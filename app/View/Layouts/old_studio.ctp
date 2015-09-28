<?php
/**
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
 * @package       cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$description = __d('public', 'Street Style Shop');
if (!isset($isFront)) {
    $isFront = false;
}
if (!isset($siteType)) {
    $siteType = 'default';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>
        <meta name="viewport"content="width=device-width, initial-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <title>
            <?php echo $title_for_layout ? $title_for_layout . ' &bull; ' : ''; ?>

            <?php echo $description ?>
        </title>
        <?php
        echo $this->Html->meta('icon', $this->Html->url('/img/layouts/default/icon.png'));
        echo $this->fetch('meta');

//        echo $this->Html->css(array('reset', 'tinymce', 'default', 'fontello', 'minimal/minimal'));
        echo $this->Html->css(array('bootstrap', '../font/fonts.css', 'font-awesome', 'default', 'select2/select2'));
        echo $this->fetch('css');
        echo $this->Html->script('jquery.min');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('feb');
//        echo $this->Html->script('jquery.icheck.min');
        echo $this->Html->script('jquery.cycle.all');
        echo $this->Html->script('select2/select2.min.js');
        echo $this->fetch('script');
        ?>
    </head>
    <body class="<?php echo $isFront ? 'front' : ''; ?> <?php echo $siteType; ?> ">

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
            return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1&appId=478348518908881";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <?php // echo $this->element('GoogleAnalytics.googleAnalytics');  ?>
        <?php echo $this->Html->requestAction(array('plugin' => 'browser', 'controller' => 'browsers', 'action' => 'browser', 'admin' => false)); ?>
        <div class="contain">
            <div id="header">
                <div class="container">
                    <div class="row-fluid">
                        <div id="areas" class="span12">
                            <div class="row-fluid">
                                <div class="span4">
                                    <h3>Wybierz strefę:</h3>
                                </div>
                                <div class="span8">
                                    <?php echo $this->element('default/top_menu'); ?>
                                </div>
                            </div>
                            <?php echo $this->Session->flash(); ?>
                            <?php echo $this->Session->flash('auth'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="topMenu">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span4">
                            <?php echo $this->Html->link($this->Html->image('layouts/default/logo.jpg'), '/', array('escape' => false, 'id' => 'logo')); ?>
                        </div>
                        <div class="span8">
                            <?php echo $this->element('default/search'); ?>
                        </div>
                    </div>
                    <div id="menu-shop" class="row-fluid">
                        <div class="span8 my-span8 bt-no-margin">
                            <ul class="menu">
                                <!--                                <li><a href="#">Nowości</a></li>
                                                                <li><a href="#">Ubrania</a></li>
                                                                <li><a href="#">Buty</a></li>
                                                                <li><a href="#">Akcesoria</a></li>
                                                                <li><a href="#">Czapki</a></li>
                                                                <li><a href="#">Promocje</a></li>-->
                                <?php
                                echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'static_product', 'controller' => 'products_categories', 'action' => 'front_text_list'));
                                ?>
                            </ul>
                        </div>
                        <div class="span4 my-span4 bt-no-margin">
                            <?php echo $this->Html->requestAction(array('controller' => 'orders', 'action' => 'front_cart_info', 'plugin' => 'commerce', 'admin' => false)); ?>
                        </div>
                    </div>
                    <?php // echo $menu = $this->Html->requestAction(array('controller' => 'menus', 'action' => 'menu', 'plugin' => 'menu', 'admin' => false)); ?>
                    <?php //echo $this->Html->link("Blog", array('plugin' => 'news', 'controller' => 'news', 'action' => 'blog')); ?>
                    <?php // echo $this->Html->link(__("Blog"), array('plugin' => 'info', 'controller' => 'info_pages', 'action' => 'index', 'blog')); ?>
                    <?php //echo $this->Html->link("Aktualności2", array('plugin' => 'info', 'controller' => 'info_pages', 'action' => 'index', 'news')); ?>
                    <?php // echo $this->Html->link(__("Kalkulator"), array('plugin' => false, 'controller' => 'calculators', 'action' => 'index')); ?>
                </div>
            </div>


            <div id="content">
                <div class="container">

                    <?php echo $this->fetch('content'); ?>
                </div>
            </div>


            <div class="container">
                <div id="naviFooter" class="clearfix">
                    <div class="my-row row-fluid">
                        <div class="span4 my-span4 menu-site">
                            <?php echo $this->element('default/bottom_menu'); ?>
                        </div>
                        <div class="span8 my-span8 bt-no-margin menu-cms">
                            <?php echo $this->Html->requestAction(array('controller' => 'menus', 'action' => 'menu', 'plugin' => 'menu', 'admin' => false, 44)); ?>
                        </div>
                    </div>
                </div>
                <div id="footer" class="clearfix">
                    <div class="row">
                        <div class="span4">
                            © 2009-<?php echo date('Y'); ?> StreetstyleSHop<br/>
                            e-commerce by <?php echo $this->Html->link('feb.net.pl', 'http://feb.net.pl'); ?><br/>
                                <!--LiveInternet counter--><script type="text/javascript"><!--
                                document.write("<a href='//www.liveinternet.ru/click' "+
                                "target=_blank><img src='//counter.yadro.ru/hit?t41.1;r"+
                                escape(document.referrer)+((typeof(screen)=="undefined")?"":
                                ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                                screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                                ";"+Math.random()+
                                "' alt='' title='LiveInternet' "+
                                "border='0' width='31' height='31'><\/a>")
                                //--></script><!--/LiveInternet-->

                        </div>
                        <div class="span8">
                            <?php echo $this->Html->image('/img/layouts/default/footer-pays.jpg', array('class' => 'fr')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
            //<![CDATA[
            $('#flashMessage').click(function() {
            $(this).hide();
            });
            //]]>
        </script>
        <?php echo $this->element('Eurocookie.cookie'); ?>
        <?php
        if (Configure::read('debug') >= 2)
            echo $this->element('sql_dump');
        ?>
    </body>
</html>