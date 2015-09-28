<?php $this->set('isFront', true); ?>
<?php
    if (Configure::read('Meta.studio.title')) {
        $this->set('title_for_layout', Configure::read('Meta.studio.title')); 
    }
    else {
        $this->set('title_for_layout', __d('cms', 'Studio')); 
    }
?>

<!--środek strony-->
<div class="studio-srodek1">
    <div class="studio-srodek">
        <h2><?php echo __d('front', 'PROFESJONALNE STUDIO NAGRAŃ'); ?></h2>
        <div class="player" class="clearfix">
            <!--<span>Drumsound & Bassline Smith - Atmosphere (Official Video)</span>-->
            <?php // echo $this->Html->link($this->Html->image('/img/layouts/default/studio-strzalka.jpg'), '#', array('class' => '', 'escape'=>false)); ?>
            <?php // echo $this->Html->image('/img/layouts/default/music.png'); ?>
            <?php echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'studio', 'controller' => 'studio_movies', 'action' => 'movies_main', 'type' => 'studio')); ?>
        </div>
    </div>

</div>
<div class="row">
    <div class="span12">

    </div>
</div>
<div class="allMedias">
    <div class="row-fluid">
        <?php echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'studio', 'controller' => 'studio_movies', 'action' => 'all_movies', 'type' => 'studio')); ?>
    </div>
</div>
<!--<div class="film">-->
<?php //echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'studio', 'controller' => 'studio_movies', 'action' => 'movies_list', 'type' => 'studio')); ?>
<!--<b>Dr DRE FEAT SNOOP DOGG <br />
    - NEXT EPISODE (UP IN SMOKE TOUR)</b>
<iframe width="300" height="200" src="//www.youtube.com/embed/403ZDwJ9QrE" frameborder="0" allowfullscreen></iframe>
<br />
<div class="strzalka-blok"><?php echo $this->Html->link($this->Html->image('/img/layouts/default/studio-strzalka.jpg'), '#', array('class' => '', 'escape' => false)); ?>
    <p>DRUMSOUND & BASSLINE SMITH - ATMOSPHERE (OFFICIAL VIDEO)</p>
</div>
<div class="strzalka-blok"><?php echo $this->Html->link($this->Html->image('/img/layouts/default/studio-strzalka.jpg'), '#', array('class' => '', 'escape' => false)); ?>
    <p>DRUMSOUND & BASSLINE SMITH - ATMOSPHERE (OFFICIAL VIDEO)</p>
</div>
<div class="strzalka-blok"><?php echo $this->Html->link($this->Html->image('/img/layouts/default/studio-strzalka.jpg'), '#', array('class' => '', 'escape' => false)); ?>
    <p>DRUMSOUND & BASSLINE SMITH - ATMOSPHERE (OFFICIAL VIDEO)</p>
</div>
<div class="strzalka-blok"><?php echo $this->Html->link($this->Html->image('/img/layouts/default/studio-strzalka.jpg'), '#', array('class' => '', 'escape' => false)); ?>
    <p>DRUMSOUND & BASSLINE SMITH - ATMOSPHERE (OFFICIAL VIDEO)</p>
</div>-->
<!--</div>-->
<!--koniec srodka-->   