<?php $this->set('title_for_layout', $strona['Page']['name']); ?>
<?php
$keywords = Configure::read('Meta.studio.key');
$keywords .= empty($strona['Page']['keywords']) ? " " : " " . $strona['Page']['keywords'];
$description = Configure::read('Meta.studio.desc');
$description .= empty($strona['Page']['description']) ? " " : " " . $strona['Page']['description'];
$this->Html->meta('description', $description, array('inline' => false));
$this->Html->meta('keywords', $keywords, array('inline' => false));
?>
<?php // $this->Html->css('podstrona', null, array('inline' => false));       ?>

<?php $this->Html->addCrumb(__d('cms', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb($strona['Page']['name']); ?>
<div id="page" class="view noDefLay layoutType_<?php echo Page::$categories[$layoutType]; ?>">
    <div class="row-fluid">
        <div class="breadcrump span8 my-span8 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
        <div class="white-background clearfix">
            <div class="clearfix">
                <div class="border-page clearfix padding20 span12">
                    <div class="clearfix title">
                        <h1><?php echo $strona['Page']['name']; ?></h1>
                    </div>
                    <div id="tinymce">
                        <?php echo $strona['Page']['desc']; ?>
                        <?php // echo!empty($strona['Page']['static']) ? $this->element('StaticPage/' . $strona['Page']['static']) : ''; ?>
                        <?php // debug($strona) ?>
                        <div class="news-gallery gallery clearfix">
                            <?php
                            foreach ($strona['Photos'] as $gallery) {
                                $galParam1 = array('width' => 700, 'height' => 520);
                                $galParam2 = array('rel' => 'gallery01', 'class' => 'fancy', 'escape' => false);
                                    echo $this->Html->div('gallery', $this->Image->thumb('/files/photo/' . $gallery['img'], $galParam1));
                            }
                            ?>
                        </div>
                        <?php echo ($strona['Page']['comments'] == 1) ? $this->element('Pages.Comments/comments') : ''; ?>
                    </div>
                    <?php echo!empty($strona['Page']['static']) ? $this->element('StaticPage/' . $strona['Page']['static']) : ''; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    //<![CDATA[
    if ($('#page').hasClass('noDefLay')) {
        var layType = $('#page').attr('class');
        layType = layType.split(" ");
        len = layType.length;
//            layType = layType.search('layoutType_');
        var i = 0;
        var type;
        for (i = 0; i < len; i++) {
            if (layType[i].search('layoutType_') >= 0) {
                type = layType[i];
            }
        }
        var tmpType = type;
        var typeLen = type.length;
        var tmpLen = 'layoutType_'.length;
        type = tmpType.substr(tmpLen, typeLen);
        console.debug(tmpType);
        console.debug(typeLen);
        console.debug(tmpLen);
        console.debug(type);

        $('body').removeClass(' default ').addClass(type);
    }
    //]]>
</script>

<?php
$this->Html->addCrumb($strona['Page']['name'], $this->here);
$this->Fancybox->init('jQuery(".gallery a")');
?>