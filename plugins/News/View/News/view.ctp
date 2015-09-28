<?php
//$keywords = Configure::read('Meta.blog.key');
//$keywords .= empty($news['NewsCategory']['metakey']) ? "" : " " . $news['NewsCategory']['metakey'];
//$keywords .= empty($news['News']['metakey']) ? "" : " " . $news['News']['metakey'];
//$description = Configure::read('Meta.blog.desc');
//$description .= empty($news['NewsCategory']['metadesc']) ? "" : " " . $news['NewsCategory']['metadesc'];
//$description .= empty($news['News']['metadesc']) ? "" : " " . $news['News']['metadesc'];
//
//echo $this->Html->meta('keywords', $keywords, array('inline' => false));
//echo $this->Html->meta('description', $description, array('inline' => false));

echo $this->element('News/meta', array('news' => $news['News'], 'category' => $news['NewsCategory']));

$this->set('title_for_layout', $news['News']['title'] . ' &bull; ' . __d('cms', 'Blog'));

//kody reklam dla wpisu


$this->Html->addCrumb(__d('cms', 'Strona główna'), '/blog'); 
$this->Html->addCrumb($category['NewsCategory']['name'], array('type'=>'blog','plugin'=>'news','controller'=>'news','action'=>'index',$category['NewsCategory']['slug'])); 
$this->Html->addCrumb($news['News']['title']); 

$this->set('AdForNews', ($news['News']['head_code']) ? $news['News']['head_code'] : '');
//$this->set('AdForNews2', ($news['News']['ad_code2']) ? $news['News']['ad_code2'] : '');
?>
<div class="container">
    <div class="row-fluid">
        <div class="breadcrump span8 my-span8 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="row-fluid whiteBg">
        <div id="newsIndex" class="span8">

            <div class="page-container">
                <div class="container-fluid">
                    <div class="span12 blog clearfix news-item page-news-list one-page-news">
                        <header class="blogHead">
                            <?php //  debug($news);  ?>
                            <h3><?php echo $this->Html->link($news['News']['title'], '#'); ?></h3> 
                            <div class="dataBlog">
                                <p><?php echo strftime('%a, %e %B %G', strtotime($news['News']['date'])); ?></p>
                                <!--<p><?php // echo $this->Time->format('d.m.Y', $news['News']['date']);     ?></p>-->
                                <p><?php echo __d('front', 'AUTOR'); ?>: 
                                    <?php $opts = array('type' => 'blog', 'plugin' => 'news', 'controller' => 'news', 'action' => 'author', $news['User']['id']); ?>
                                    <?php echo $this->Html->link($news['User']['name'], $opts, array('class' => 'catBlogA')); ?>
                                </p>
                                <span><?php echo $this->Html->link($news['NewsCategory']['name'], array('type' => 'blog', 'controller' => 'news', 'plugin' => 'news', 'action' => 'index', $category['NewsCategory']['slug'])); ?></span>
                            </div>
                        </header>
                        <?php //debug($news); ?>
                        <div style="text-align: center; margin-bottom: 25px;">
                            <?php if (!empty($news['Photo']['img'])): ?>
                                <?php echo $this->Html->image('/files/photo/' . $news['Photo']['img']); ?>
                            <?php endif; ?>
                        </div>
                        <div id="tinymce" class="news-item">
                            <span class="contentBlog"><?php echo $news['News']['content']; ?></span>
                            <div class="news-gallery gallery clearfix" style="margin-top: 25px;">
                                <?php
                                foreach ($news['Photos'] as $gallery) {
//                                    echo $this->Html->div('gallery', $this->Image->thumb('/files/photo/' . $gallery['img'], array('width' => 175, 'height' => 150, 'crop' => true), array('url' => '/files/photo/' . $gallery['img'])), array('escape' => false));
                                    $galParam1 = array('width' => 700, 'height' => 520);
                                    $galParam2 = array('rel' => 'gallery01', 'class' => 'fancy', 'escape' => false);
                                    if ($gallery['id'] !== $news['News']['photo_id']) {
                                        echo $this->Html->div('gallery', $this->Html->image('/files/photo/' . $gallery['img']));
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="" style='float:left;margin-left: 70px;margin-bottom: 40px'>
                            <?php echo $news['News']['ad_code']; ?>
                        </div>
                        <div class="socialButtons blogView fl">
                            <p class="fl"><?php echo __d('front', 'Komentarzy'); ?>: <span><?php echo count($news['Comment']); ?></span></p>
                            <div class="fl" id="fb-root"></div>
                            <script>(function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id))
                                        return;
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = "//connect.facebook.net/ru_RU/all.js";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-like" data-href="<?php echo $this->Html->url(null, true); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                            <a href="https://twitter.com/share?url=<?php echo $this->Html->url(null, true); ?>" class="twitter-share-button fl" data-url="https://twitter.com/STREETSTYLEshop" data-lang="ru"><?php echo __d('front', 'Tweetnij'); ?></a>
                            <script>!function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                    if (!d.getElementById(id)) {
                                        js = d.createElement(s);
                                        js.id = id;
                                        js.src = p + '://platform.twitter.com/widgets.js';
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }
                                }(document, 'script', 'twitter-wjs');</script>
                            <!-- Put this div tag to the place, where the Like block will be -->
                            <div id="vk_like"></div>
                            <script type="text/javascript">
                                VK.Widgets.Like("vk_like", {type: "button", verb: 1});
                            </script>
                        </div>



                        <div class="publicBlog" id="add_comment">
                            <?php
                            $user_id = $this->Session->read('Auth.User.id');
                            if (!empty($user_id)) {
                                //echo $this->element('News.Comments/comments');
                                echo $this->element('News.News/comments');
//                                echo $this->Html->requestAction(array('plugin'=>'comment','controller'=>'comments','action'=>'menu'));
                            } else {
                                echo '<b style="color:black">'.__d('front', 'Zaloguj się,').' '.$this->Html->link(__d('front', 'aby dodać komentarz'), array('plugin' => 'user', 'controller' => 'users', 'action' => 'register'), array('class' => '')).'</b>';
//                                echo '<b style="color:black">' . __d('front', 'Zaloguj się, aby dodać komentarz') . '</b>';
                            }
                            ?>
                        </div>
                        <div id="blogComment">
                            <?php echo $this->Html->requestAction(array('plugin' => 'comment', 'controller' => 'comments', 'action' => 'menu', 1, $news['News']['id'])); ?>
                            <?php // echo $this->element('News.News/comment-template');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".addComment").on('click', function() {
//            window.location.hash = 'add_comment';
            var dataId = $(this).attr('data-id');
            $('#CommentParentId').val(dataId);
            $('.comment_reply_id').attr('href', '<?php echo $this->Html->url(); ?>#comment-' + dataId);
            $('.reply_to_comment').show();

            $('html, body').animate({
                scrollTop: ($('#add_comment').offset().top)
            }, 500);
            return false;
        });

        $(".cancel_reply").on('click', function() {
            $('.reply_to_comment').hide();
            return false;
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".gallery a").fancybox();
    });
</script>
<?php
//$this->Fancybox->init('jQuery(".news-gallery a")');
?>