<div class="half clearfix">
<?php
foreach ($banners as $banner):
    echo $this->element('Banner.Banners/banner', compact('product', 'type'));
endforeach;
?>
</div>