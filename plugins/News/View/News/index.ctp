<?php
//$keywords = Configure::read('Meta.blog.key');
//$keywords .= empty($currentCategory['NewsCategory']['metakey']) ? "" : ' ' . $currentCategory['NewsCategory']['metakey'];
//$description = Configure::read('Meta.blog.desc');
//$description .= empty($currentCategory['NewsCategory']['metadesc']) ? "" : ' ' . $currentCategory['NewsCategory']['metadesc'];
//
//echo $this->Html->meta('description', $description, array('inline' => false));
//echo $this->Html->meta('keywords', $keywords, array('inline' => false));

echo $this->element('News/meta', array('news' => false, 'category' => empty($currentCategory['NewsCategory']) ? false : $currentCategory['NewsCategory']));

if (Configure::read('Meta.blog.title')) {
    $title = Configure::read('Meta.blog.title');
}
else {
    $title = __d('cms', 'Blog');
}
if (!empty($currentCategory['NewsCategory']['name'])) {
    $title = $currentCategory['NewsCategory']['name'] . ' &bull; ' . $title;
}
$this->set('title_for_layout', $title); 
    
if (!empty($category_slug) && !empty($currentCategory)):
    $this->set('AdForNewsCat', ($currentCategory['NewsCategory']['head_code']) ? $currentCategory['NewsCategory']['head_code'] : '');
//    $this->set('AdForNewsCat2', ($currentCategory['NewsCategory']['ad_code2']) ? $currentCategory['NewsCategory']['ad_code2'] : '');
endif;

if(!empty($currentCategory)): 
$this->Html->addCrumb(__d('cms', 'Strona główna'), '/blog'); 
$this->Html->addCrumb($currentCategory['NewsCategory']['name']); 
endif;

$this->set('currentCategory', empty($currentCategory) ? null : $currentCategory);
?>
<div class="container">
    <?php if(!empty($currentCategory)): ?>
        <div class="row-fluid">
            <div class="breadcrump span8 my-span8 bt-no-margin">
                <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row-fluid whiteBg">
        <div id="newsIndex" class="span8">
            <div class="page-container">
                <!-- <h2 id="h2-news" class="sprites hide-text">Aktualności</h2>-->
                <div class="container-fluid">
                    <?php
                    $i = 0;
                    $howMany = count($news);
                    foreach ($news as $new) {
                        preg_match('/<p[^<]+(?:<a[^<]+)?<img[^<>]+src="([^"]+)"/', $new['News']['tiny_content'], $matches);
                        if (empty($matches)) {
                            preg_match('/<img[^<>]+src="([^"]+)"/', $new['News']['tiny_content'], $matches);
                        }
                        $new['News']['tiny_content'] = preg_replace('/<p[^<]+(?:<a[^<]+)?<img[^>]+>(?:[^>]+>)?<\/p>/', '', $new['News']['tiny_content']);
                        $new['News']['tiny_content'] = preg_replace('/<img[^>]+>/', '', $new['News']['tiny_content']);
                        $i++;
                        echo ($i % 2 == 1) ? '<div class="row-fluid">' : '';

                        $viewLink = array('action' => 'view', $new['News']['slug'], 'type' => 'blog');
                        ?>
                        <div class="span12 blog clearfix news-item page-news-list news-list-items">
                            <header class="blogHead">
                                <h3><?php echo $this->Html->link($new['News']['title'], $viewLink); ?></h3> 
                                <div class="dataBlog">
                                    <p>
                                        <?php echo strftime('%a, %e %B %G', strtotime($new['News']['date'])); ?>
                                    </p>
                                    <p><?php echo __d('front', 'AUTOR'); ?>: 
                                        <?php $opts = array('type' => 'blog', 'plugin' => 'news', 'controller' => 'news', 'action' => 'author', $new['User']['id']); ?>
                                        <?php echo $this->Html->link($new['User']['name'], $opts, array('class' => 'catBlogA')); ?>
                                    </p>
                                    <span>
                                        <?php $newsCategorySlug = array_search($new['NewsCategory']['id'], $newsCategoriesId); ?>
                                        <?php $NewsCategoryLink = array('plugin' => 'news', 'controller' => 'news', 'action' => 'index', $newsCategorySlug, 'type' => 'blog'); ?>
                                        <?php echo $this->Html->link($new['NewsCategory']['name'], $NewsCategoryLink); ?>
                                    </span>
                                </div>
                            </header>
                            <div class="bigFoto">
                                <?php if (!empty($new['Photo']['img'])): ?>
                                    <?php echo $this->Html->Image('/files/photo/' . $new['Photo']['img'], array('url' => $viewLink)); ?>
                                <?php elseif (!empty($matches[1])): ?>
                                    <?php echo $this->Html->image('../' . $matches[1], array('url' => $viewLink)); ?>
                                <?php endif; ?>
                            </div>

                            <?php echo $this->Html->link(__d('front', 'CZYTAJ CAŁY ARTYKUŁ'), $viewLink, array('class' => 'moreBlog', 'escape' => false)) ?>
                            <?php // echo $this->Html->image('/files/photo/' . $new['Photo']['img'], array('url' => $viewLink)); ?>
                            <div class="socialButtons">
                                <p><?php echo __d('front', 'Komentarzy'); ?>: <span><?php echo count($new['Comment']); ?></span></p>


                                <a href="https://twitter.com/share?url=<?php echo $this->Html->url($viewLink, true); ?>" class="twitter-share-button" data-url="https://twitter.com/STREETSTYLEshop" data-lang="ru"><?php echo __d('front', 'Tweetnij'); ?></a>
                                <script>!function(d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                        if (!d.getElementById(id)) {
                                            js = d.createElement(s);
                                            js.id = id;
                                            js.src = p + '://platform.twitter.com/widgets.js';
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }
                                    }(document, 'script', 'twitter-wjs');</script>
                                <!--<div class="fb-like" data-href="<?php echo $this->Html->url($viewLink, true); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>-->
                                <!-- Put this div tag to the place, where the Like block will be -->
                                <div id="vk_like<?php echo $new['News']['id'] ?>" class="vkontakt"></div>
                                <script type="text/javascript">
                                    VK.Widgets.Like("vk_like<?php echo $new['News']['id'] ?>", {type: "button", height: 20, pageUrl: '<?php echo $this->Html->url($viewLink, true); ?>'});
                                </script>
                            </div>
                            <div class="contentBlog">

                                <?php if (!empty($new['News']['tiny_content'])): ?>
                                    <?php echo $new['News']['tiny_content']; ?>
                                <?php endif; ?>

                                <?php // echo $this->Text->truncate(strip_tags($new['News']['content']), 396); ?>
                            </div>
                        </div>
                        <?php
                        echo ($i % 2 == 0 || $i == $howMany) ? '</div>' : '';
                    }
                    ?>

                </div>
                <?php //echo $this->Html->link('NOWSZE POSTY', '#', array('class' => 'newOldBox sendOrSearch fl')); ?>
                <?php //echo $this->Html->link('STARSZE POSTY', '#', array('class' => 'newOldBox sendOrSearch fr')); ?>
                <?php echo $this->Paginator->next(__d('front', 'NOWSZE POSTY'), array('class' => 'newOldBox sendOrSearch fr')); ?>
                <?php echo $this->Paginator->prev(__d('front', 'STARSZE POSTY'), array('class' => 'newOldBox sendOrSearch fl')); ?>

            </div>
            <?php //echo $this->element('News/archiwum'); ?>
            <?php // $this->Paginator->options(array('update' => '#newsIndex', 'evalScripts' => true)); ?>
            <?php echo $this->element('default/paginator'); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.contentBlog span').attr('style', false);
        $('.contentBlog p').attr('style', false);
    })
</script>
<?php echo $this->Js->writeBuffer(); ?>

