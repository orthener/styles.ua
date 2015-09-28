<div id="leftMenu" class="clearfix">
    <button id="clipButton"></button>
    <div id="leftMenuContent">
        <h2><span><?php echo __d('cms', 'MENU GŁÓWNE'); ?></span></h2>
        <ul>
            <li><?php echo $this->Html->link(__d('cms', 'PORTAL'), '/', array('outter' => '<li>%s</li>')); ?></li>
            <?php echo $this->Permissions->link(__d('cms', 'CMS'), '/admin', array('outter' => '<li>%s</li>')); ?>
        	<li><?php echo $this->Html->link(__d('cms', 'WYLOGUJ'), array('admin' => false, 'controller' => 'users', 'action'=>'logout')); ?></li>
        </ul>
        <h2><span><?php echo __d('cms', 'Strony'); ?></span></h2>
        <ul>
            <?php echo $this->Permissions->link(__d('cms', 'Menu strony'), array('plugin' => 'menu', 'controller' => 'menus', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Strony statyczne'), array('plugin' => 'page', 'controller' => 'pages', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Banery'), array('plugin' => 'banner', 'controller' => 'banners', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Elementy dynamiczne'), array('plugin' => 'dynamic_elements', 'controller' => 'dynamic_elements', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        </ul>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
	jQuery('#leftMenu button').click(function(){
	   var content = jQuery('#content');
	   var isClass = content.hasClass('clip')
	   if(isClass){
	       content.removeClass('clip');
	       jQuery(this).addClass('active');
	       jQuery.post('<?php echo $this->Html->url(array('plugin' => 'user','controller'=>'users','action'=>'menu','admin'=>true, 1)); ?>');
	   }else{
	       content.addClass('clip');
	       jQuery(this).removeClass('active');
	       jQuery.post('<?php echo $this->Html->url(array('plugin' => 'user', 'controller'=>'users','action'=>'menu','admin'=>true, 0)); ?>');
	   }
	   
	});
	jQuery('div.actions ul').each(function(){
	   jQuery('<h2><span><?php echo __d('cms', 'Opcje')?></span></h2>').appendTo(jQuery('#leftMenuContent'));
	   jQuery(this).appendTo(jQuery('#leftMenuContent'));
	})
	
//]]>	
</script>