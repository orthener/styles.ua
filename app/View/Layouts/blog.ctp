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
$this->set('title_for_layout', __d('public', 'Blog'));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>
        <meta name="viewport"content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <?php if ((strpos($_SERVER['SERVER_NAME'], '.feb.net.pl') > 0) || ((Configure::read('Meta.robots') == 'noindex'))): ?>
            <meta name="robots" content="noindex, nofollow" />
        <?php else: ?>
            <meta name="robots" content="index, follow" />
        <?php endif; ?>
        <title>
            <?php echo $title_for_layout ? $title_for_layout . ' &bull; ' : ''; ?>
            <?php echo $description; ?>
        </title>
        <base href="<?php echo $this->Html->url('/', true); ?>"/>
        <?php
        echo $this->Html->meta('icon', $this->Html->url('/img/layouts/default/icon.png'))."\n";
        if ($isFront) {
            echo $this->Html->meta('keywords', Configure::read('Meta.blog_key'))."\n";
            echo $this->Html->meta('description', Configure::read('Meta.blog_desc'))."\n";
        }
        if(isset($news['News']['title'])) {
            echo '<meta name="title" content="'.$news['News']['title'].'" />';
        }
        echo $this->fetch('meta');

//        echo $this->Html->css(array('reset', 'tinymce', 'default', 'fontello', 'minimal/minimal'));
        echo $this->Html->css(array('bootstrap', 'jquery.fancybox', '../font/fonts.css', 'fonts', 'font-awesome', 'default', 'select2/select2', 'jquery.selectbox'));
        echo $this->fetch('css');

        echo $this->Html->script('jquery.min');
        echo $this->Html->script('jquery-migrate-1.2.1.min');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('jquery.fancybox');
        echo $this->Html->script('jquery.fancybox.pack');
        echo $this->Html->script('feb');
        echo $this->Html->script('jquery.blinker.min');
        echo $this->Html->script(array('jquery.selectbox-0.2.min', 'shop'));
        echo $this->Html->script('jquery.icheck.min');
        echo $this->Html->script('jquery.cycle.all');
        echo $this->Html->script('select2/select2.min.js');
        echo $this->fetch('script');
        ?>
        
        <!-- Put this script tag to the <head> of your page -->
        <script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>
        <script type="text/javascript">
            VK.init({apiId: 4598523, onlyWidgets: true});
        </script>

        <?php
        //kody reklam
        //jeśli jest kod dla wpisu
        if (isset($AdForNews) && !empty($AdForNews)):
            //kod dla wpisu
            echo "<!-- reklama dla newsa -->";
            echo $AdForNews;
            echo "<!-- reklama dla newsa -->";
        //jeśli nie ma kodu dla wpisu, ale jest dla kategorii
        elseif (isset($AdForNewsCat) && !empty($AdForNewsCat)):
            //kod dla kategorii
            echo "<!-- reklama dla kategorii -->";
            echo $AdForNewsCat;
            echo "<!-- reklama dla kategorii -->";
        //jeśli nie ma dla wpisu i kategorii, a jest dla całej strony
        else:
            //kod dla strony
            echo "<!-- reklama dla strony -->";
            echo Configure::read('Ad.head_code');
            echo "<!-- reklama dla strony -->";
        endif;
        ?>
        <?php
        // print article meta images for vk.com
        if(isset($news['Photos'])) {
            foreach ($news['Photos'] as $img) {
                echo '<link rel="image_src" href="'.$this->Html->url('/files/photo/'.$img['img'], true).'" />'."\n";
            }
        }
        ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-31537681-1', 'streetstyleshop.com.ua');
          ga('send', 'pageview');

        </script>
    </head>
    <body class="<?php echo $isFront ? 'front' : ''; ?> <?php echo $siteType; ?> ">
        <a href="#" class="openRight blue"></a>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <?php // echo $this->element('GoogleAnalytics.googleAnalytics');   ?>
        <?php echo $this->Html->requestAction(array('plugin' => 'browser', 'controller' => 'browsers', 'action' => 'browser', 'admin' => false)); ?>
        <div class="contain">
            <div id="header">
                <div class="container">
                    <div class="loginBox row-fluid">
                        <div class="span12" style="margin-top: 15px;">
                            <?php echo $this->element('User.Users/login_module'); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div id="areas" class="span12">
                            <div class="row-fluid">
                                <div class="span4">
                                    <h3><?php echo __d('front', 'Wybierz strefę'); ?>:</h3>
                                </div>
                                <div class="span8">
                                    <?php echo $this->element('default/top_menu'); ?>
                                </div>
                            </div>
                            <?php echo $this->Session->flash(); ?>
                            <?php echo $this->Session->flash('auth'); ?>
                            <div id="flashContent"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="topMenu">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span4">
                            <?php echo $this->Html->link($this->Html->image('layouts/default/logo_blog.jpg'), '/blog', array('escape' => false, 'id' => 'logo')); ?>
                        </div>
                        <div class="span8">
                            <?php echo $this->element('default/search_blog'); ?>
                        </div>
                    </div>
                    <div id="menu-shop" class="row-fluid">
                        <div class="span8 my-span8 bt-no-margin">
                            <ul class="menu">
                                <?php // echo $this->Html->requestAction(array('controller' => 'menus', 'action' => 'menu', 'plugin' => 'menu', 'admin' => false, 57, $siteType)); ?>
                                <?php echo $this->Html->requestAction(array('controller' => 'menus', 'action' => 'menu', 'admin' => false, 'plugin' => 'menu', Menu::$front_modes[$siteType])); ?>
                                <?php //foreach ($newsCategories as $id => $category) : ?>
                                    <!--<li><?php // echo $this->Html->link($category, array('type' => 'blog', 'plugin' => 'news', 'controller' => 'news', 'action' => 'index', $id));        ?></li>-->
                                <?php //endforeach; ?>
                            </ul>
                        </div>
                        <div class="span4 my-span4 bt-no-margin">
                            <?php // echo $this->Html->requestAction(array('controller' => 'orders', 'action' => 'front_cart_info', 'plugin' => 'commerce', 'admin' => false));  ?>
                        </div>
                    </div>
                    <?php // echo $menu = $this->Html->requestAction(array('controller' => 'menus', 'action' => 'menu', 'plugin' => 'menu', 'admin' => false));  ?>
                    <?php //echo $this->Html->link("Blog", array('plugin' => 'news', 'controller' => 'news', 'action' => 'blog')); ?>
                    <?php // echo $this->Html->link(__("Blog"), array('plugin' => 'info', 'controller' => 'info_pages', 'action' => 'index', 'blog')); ?>
                    <?php //echo $this->Html->link("Aktualności2", array('plugin' => 'info', 'controller' => 'info_pages', 'action' => 'index', 'news')); ?>
                    <?php // echo $this->Html->link(__("Kalkulator"), array('plugin' => false, 'controller' => 'calculators', 'action' => 'index')); ?>
                </div>
            </div>


            <div id="content">
                <div class="container">
                    <div class="row-fluid blogFluid">
                        <div class="span8">
                            <?php echo $this->fetch('content'); ?>
                        </div>
                        <div class="span4 boxOnResponse">
                            <div class="boxBlog">
                                <!--                                <div class="withPadding">
                                                                    <div class="loginBox" style="margin-top: 15px;">
                                <?php echo $this->element('User.Users/login_module'); ?>
                                                                    </div>
                                                                </div>-->
                                <?php //echo $this->Html->image('/img/layouts/default/10deep.png'); ?>
                                <?php $currentCategory = empty($currentCategory) ? 0 : $currentCategory['NewsCategory']['slug']; ?>
                                <?php $current_news_id = empty($current_news_id) ? 0 : $current_news_id; ?>
                                <?php echo $this->Html->requestAction(array('plugin' => 'news', 'controller' => 'news', 'action' => 'right_box', $this->Html->url(null, true), $currentCategory, $current_news_id)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="content">
                    <div class="container">
                        <div class="row-fluid">
                            <div class="span12">
                                <?php echo $this->Html->requestAction(array('plugin' => 'news', 'controller' => 'news', 'action' => 'populars_promoted')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div id="naviFooter" class="clearfix blogFoot1">
                        <div class="my-row blogFoot2 row-fluid">
                            <div class="span4 my-span4 menu-site">
                                <?php echo $this->element('default/bottom_menu'); ?>
                            </div>
                            <div class="span8 my-span8 bt-no-margin menu-cms">
                                <?php // echo $this->Html->requestAction(array('controller' => 'menus', 'action' => 'menu', 'plugin' => 'menu', 'admin' => false, 44)); ?>
                                <?php echo $this->Html->requestAction(array('controller' => 'menus', 'action' => 'menu', 'admin' => false, 'plugin' => 'menu', Menu::$front_modes['blog_stopka'])); ?>
                            </div>
                        </div>
                    </div>
                    <div id="footer" class="blogFoot2 clearfix">
                        <div class="row">
                            <div class="span4">
                                © 2009-<?php echo date('Y'); ?> StreetstyleSHop<br/>
                                e-commerce by <?php echo $this->Html->link('feb.net.pl', 'http://feb.net.pl', array('rel'=>'nofollow')); ?><br/>
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
                            <div class="span8 paysFoot">
                                <?php echo $this->Html->image('/img/layouts/default/footer-pays2.png', array('class' => 'fr')); ?>
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

                jQuery('#products .product').click(function() {
                    window.location = jQuery(this).attr('href');
                });

                $('.openRight').click(function() {
                    $('.boxOnResponse').toggle();
                    if (!($('body.blog .openRight').hasClass('clicked'))) {
                        $('body.blog .openRight').css({'right': '289px'}).addClass('clicked');
                    }
                    else {
                        $('body.blog .openRight').css({'right': '0px'}).removeClass('clicked');
                    }
                    return false;
                })
                //]]>
            </script>

            <?php echo $this->element('Eurocookie.cookie'); ?>
            <?php
            if (Configure::read('debug') >= 2) {
                // @isinfo - zakomentuj jeśli używasz DebugKit
                //echo $this->element('sql_dump');
            }
            ?>
    </body>
</html>