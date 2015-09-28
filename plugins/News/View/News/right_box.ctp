<?php if (!empty($Ad['code1']) && empty($disable_blog_banners)): ?>
    <div id='AdBlogCode1'><?php echo $Ad['code1']; ?></div>
<?php elseif (empty($Ad['code1']) && empty($disable_blog_banners)) : ?>
     <div id='AdBlogCode1'><?php echo Configure::read('Ad.Blog_code'); ?></div>
<?php endif; ?>
<div class="socialBox">
    <?php // echo $this->Html->link($this->Html->image('/img/layouts/default/tw.png'), '#', array('escape' => false)); ?>
<!--    <a href="#" onclick="window.open('https://twitter.com/share?url=<?php echo $url; ?>', 'twitter-share-dialog', 'width=626,height=436');
            return false;">
    <?php echo $this->Html->image('/img/layouts/default/tw.png') ?>
    </a>
    <a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>', 'facebook-share-dialog', 'width=626,height=436');
            return false;">
    <?php echo $this->Html->image('/img/layouts/default/fb.png') ?>
    </a>
    <?php // echo $this->Html->link($this->Html->image('/img/layouts/default/fb.png'), '#', array('escape' => false)); ?>
    <?php // echo $this->Html->link($this->Html->image('/img/layouts/default/vk.png'), '#', array('escape' => false)); ?>
    <a href="#" onclick="window.open('http://vkontakte.ru/share.php?url=<?php echo $url; ?>', 'facebook-share-dialog', 'width=626,height=436');
            return false;">
    <?php echo $this->Html->image('/img/layouts/default/vk.png') ?>
    </a>-->
    <a href="https://twitter.com/infostreetstyle" target="_blank" rel="nofollow">
           <?php echo $this->Html->image('/img/layouts/default/tw.png') ?>
    </a>
    <a href="https://www.facebook.com/streetstyleshop" target="_blank" rel="nofollow">
           <?php echo $this->Html->image('/img/layouts/default/fb.png') ?>
    </a>
    <?php // echo $this->Html->link($this->Html->image('/img/layouts/default/fb.png'), '#', array('escape' => false)); ?>
    <?php // echo $this->Html->link($this->Html->image('/img/layouts/default/vk.png'), '#', array('escape' => false)); ?>
    <a href="http://vk.com/streetstyleshop" target="_blank" rel="nofollow">
           <?php echo $this->Html->image('/img/layouts/default/vk.png') ?>
    </a>
</div>
<div class="withPadding">
    <h3><?php echo __d('front', 'TOP KATEGORIE'); ?></h3>
    <div class="searchSpan categorySelect">
        <?php
        echo $this->Form->create('News.Category', array('id' => 'searchForm', '#'));
        echo $this->Form->input('brand', array('options' => $newsCategories, 'empty' => __d('front', 'wybierz kategorię'), 'label' => false));
        ?>    
        <script type="text/javascript">
            $('#NewsCategoryBrand').change(function() {
                var url = '<?php echo Router::url(array('plugin' => 'news', 'controller' => 'news', 'type' => 'blog', 'action' => 'index'), true); ?>';
                document.location = url + '/' + $("#NewsCategoryBrand option:selected").val();
            });
        </script>
    </div>
    <?php foreach ($promotedCategories as $id => $category) : ?>
        <?php echo $this->Html->link($category, array('type' => 'blog', 'plugin' => 'news', 'controller' => 'news', 'action' => 'index', $id), array('class' => 'catBlogA')); ?>
    <?php endforeach; ?>
</div>
<?php //echo $this->Html->image('/img/layouts/default/tssheart.png'); ?>
<?php if (!empty($Ad['code2']) && empty($disable_blog_banners)): ?>
    <div id='AdBlogCode2'><?php echo $Ad['code2']; ?></div>
<?php elseif (empty($Ad['code1']) && empty($disable_blog_banners)) : ?>
     <div id='AdBlogCode2'><?php echo Configure::read('Ad.Blog_code2'); ?></div>
<?php endif; ?>
<div class="withPadding">
    <h3><?php echo __d('front', 'ZAPISZ SIĘ NA NASZE NEWSLETTERY'); ?></h3>
    <?php
    echo $this->Form->input('newsletter', array('label' => '', 'placeholder' => __d('front', 'twój e-mail'), 'class' => 'stdInput'));
    echo $this->Form->button(__d('front', 'ZAMÓW'), array('type' => 'submit', 'class' => 'sendOrSearch', 'id' => 'assignNewsletter'));
    ?>
</div>
<div class="borderBottomBox"></div>
<div class="withPadding">
    <h3><?php echo __d('front', 'ARCHIWUM'); ?></h3>
    <div class="searchSpan">
        <?php echo $this->element('News/archiwum'); ?>
    </div>
</div>
<div class="borderBottomBox"></div>


<!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
    VK.Widgets.Group("vk_groups", {mode: 0, width: "300", height: "400", color1: 'FFFFFF', color2: '2B587A', color3: '00aedb'}, 10141841);
</script>


<script>
    $('#assignNewsletter').click(function() {
        if (!isValidEmailAddress($('#NewsCategoryNewsletter').val())) {
            FEB.ui.flashMessage.setFlash('<?php echo __d('front', 'Podany adres email jest niepoprawny.'); ?>', 'success', 3000);
            return false;
        }
        else {
            assing_newsletter();
        }
        return false;
    });
    function assing_newsletter() {
        $.ajax({
            url: '<?php echo $this->Html->url(array('plugin' => 'newsletter', 'controller' => 'newsletters', 'action' => 'add')); ?>',
            dataType: 'html',
            type: 'POST',
            data: {
                email: $('#NewsCategoryNewsletter').val(),
            },
            success: function(data) {
                if (data == '1') {
                    FEB.ui.flashMessage.setFlash('<?php echo __d('front', 'Twój adres email został zapisany na nasz newsletter.'); ?>', 'success', 3000);
                }
                else {
                    FEB.ui.flashMessage.setFlash('<?php echo __d('front', 'Wystąpił błąd. Spróbuj ponownie później.'); ?>', 'error', 3000);
                }
            },
            error: function(o1, o2, o3, o4) {
                console.log('error');
            }
        });
    }

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }
    ;
</script>