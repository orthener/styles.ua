<?php
/**
 *Defaul layout for ayd control panel
 */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout;?> &raquo; <?php echo Configure::read('App.AppName'); ?> CMS</title>

	<?php echo $this->FebHtml->meta('icon', $this->Html->url('/img/layouts/admin/feb_ico.png')); ?>

	<!-- CSS -->
	<?php echo $this->Html->css('reset') ?>
	<?php echo $this->Html->css('login') ?>
	
	<!-- JAVASCRIPT -->
	<?php echo $this->Html->script('jquery.min'); ?> 
	<!--scripts for layout -->
	<?php echo $scripts_for_layout; ?>
</head>
<body id="loginBody">
    <div id="contentGradient">
        <div id="loginFrontPage">
            <?php echo $this->Html->image('layouts/login/feb_cms.png', array('id'=>'logoCms')); ?> 
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $content_for_layout; ?>
        </div>
        
   </div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>