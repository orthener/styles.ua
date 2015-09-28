<?php //debug($infoPage);  ?>

<?php echo $this->Html->script('jquery.cycle.all', array('inline' => false)); ?>
<div class="infoPage view">
    <h2><?php echo $infoPage['InfoPage']['title']; ?></h2>
    <h4><?php echo $infoPage['InfoPage']['publication_date']; ?></h4>
    <p><?php echo $infoPage['InfoPage']['content']; ?></p>

    <div id="imgPager" class="minis clearfix">
        <div class="gallery clearfix">
            <?php
            if (!empty($infoPage['Photos'])):
                foreach ($infoPage['Photos'] as $item) {
                    if (!empty($item['img'])):
                        echo $this->Html->div('fl thumbImg', $this->Html->link(
                                        $this->Image->thumb('/files/photo/' . $item['img'], array('width' => 55, 'height' => 55, 'frame' => '#fff'), array('itemprop' => 'image')), '/files/photo/' . $item['img'], array('rel' => 'galeria', 'escape' => false)));
                    endif;
                }
            endif;
            ?>
        </div>
    </div>
    <?php if (isset($infoPage['InfoPage']['ad_code']) && !empty($infoPage['InfoPage']['ad_code'])): ?>
        <div id="ad_code">
            <?php echo $infoPage['InfoPage']['ad_code']; ?>
        </div>
    <?php endif; ?>

    <div class="fb-comments" data-href="<?php echo $this->Html->url($this->here, true); ?>" data-width="580" data-num-posts="10"></div>



    <div class="br-bl br-br boxLight btn rightText clearfix">
        <span style="float:left">Podziel się:</span>
        <span>
         <span class="feb_social">
        <?php 
        echo $this->FebSocial->init();
        
        echo $this->FebSocial->simpleBtns(array('wykop' => array('title' => $infoPage['InfoPage']['title']), 'facebook', 'twitter', 'blip'));
        ?>
        </span>
            </span>
        <?php //echo $febSocial->init(); ?>
        <?php //echo $febSocial->simpleBtns(array('wykop' => array('title' => $infoPage['InfoPage']['title']), 'facebook', 'twitter', 'blip')); ?>
    </div>
</div>



<?php $this->Fancybox->init('jQuery(".gallery a")'); ?>