<?php
/**
 * Defaul layout for ayd control panel
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />

        <?php echo $this->Html->charset(); ?>
        <title><?php echo $title_for_layout; ?> &bull; <?php echo Configure::read('App.AppName'); ?></title>

        <?php echo $this->FebHtml->meta('icon', $this->Html->url('/img/layouts/admin/feb_ico.png')); ?>
        <?php echo $this->Html->css(array('reset', 'admin', 'shared', 'menuList', 'flag', 'ui-lightness/jquery-ui', 'jquery.datetimepicker')); ?>
        <?php echo $this->Html->script(array(
//            'jquery.min', 
            'jquery-1.7.1.min.js',
            'jquery-migrate-1.2.1.min',
            'jquery-ui.min', 
            'jquery.ui.datepicker-pl', 
            'jquery.datetimepicker', 
            'admin',
            'feb'
            )); 
        ?> 

        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body >
        <div id="container">
            <?php
            echo $this->element('cms/header');
            echo $this->element('cms/menu');
            ?>

            <div id="content" class="clearfix <?php echo $clip ? '' : 'clip'; ?>">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->Session->flash('auth'); ?>

                <div class="clearfix" id="contentCms">
                    <?php echo $this->fetch('content'); ?>
                </div>
                <?php echo $this->element('cms/left_menu'); ?>

            </div>
            <div id="footer">
                <?php echo Configure::read('App.AppName'); ?> CMS
            </div>
        </div>
        <!-- Jest debugKit więc wyłączamy -->
        <?php //echo $this->element('sql_dump'); ?>
        <?php echo $this->fetch('PermissionGroupContentMenu'); ?>
    </body>
</html>