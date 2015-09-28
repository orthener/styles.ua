<?php 
$keywords = '';
if (empty($news['metakey'])) {
    if (empty($category['metakey']) && Configure::read('Meta.blog.key')) {
        $keywords = Configure::read('Meta.blog.key');
    }
    elseif(!empty($category['metakey'])) {
        $keywords = $category['metakey'];
    }
}
else {
    $keywords = $news['metakey'];
}

$description = '';
if (empty($news['metadesc'])) {
    if (empty($category['metadesc']) && Configure::read('Meta.blog.desc')) {
        $description = Configure::read('Meta.blog.desc');
    }
    elseif(!empty($category['metadesc'])) {
        $description = $category['metadesc'];
    }
}
else {
    $description = $news['metadesc'];
}
echo $this->Html->meta('keywords', $keywords, array('inline' => false));
echo $this->Html->meta('description', $description, array('inline' => false));
?>