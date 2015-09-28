<?php $przegladarka = $browser['browser'];
$wersja = $browser['version']; ?>

<script type="text/javascript">
<?php if ($wersja == 'unknown' || $przegladarka == 'Android')
{ ?>
    var unknow = true;
<?php } else
{ ?>
    var unknow = false;
<?php } ?>
</script>
<?php if (
        $wersja != 'unknown' && 
        (
            (!$this->Session->check('Browser.notice')) &&
            (
                ($przegladarka == 'Firefox' && $wersja < 12) || 
                ($przegladarka ==   'Internet Explorer' && $wersja < 8) ||
                ($przegladarka == 'Opera' && $wersja < 9) ||
                ($przegladarka == 'Safari' && $wersja < 6) || 
                ($przegladarka == 'Chrome' && $wersja < 15)
            )
        )
    )
{ ?>


    <div id="ie6notice" class="content">
        <div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;'>

            <div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'>

                <?php // echo $html->link($html->image('http://www.ie6nomore.com/files/theme/ie6nomore-cornerx.jpg', array('alt'=>'Close this notice', 'title'=>'Zamknij')),'/nomorenotice', null,false) ?>
                <?php echo $this->Js->link($this->Html->image('Browser.ie6nomore-cornerx.jpg',
                        array('alt' => 'Close this notice', 'title' => 'Zamknij')), array('controller' =>
                        'browsers', 'action' => 'noNoticeBrowser', 'admin' => false, 'plugin' =>
                        'browser'), array('update' => '#ie6notice', 'escape' => false)); ?>

            </div>

            <div style='width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>
                <div style='width: 75px; float: left;'>
                    <?php echo $this->Html->image('Browser.ie6nomore-warning.jpg',array('alt' => 'Warning!')); ?>
                </div>
                <div style='width: 275px; float: left; font-family: Arial, sans-serif;'>
                    <div style='font-size: 14px; font-weight: bold; margin-top: 12px;'>
                        Używana jest przestarzała przeglądarka
                    </div>
                    <div style='font-size: 12px; margin-top: 6px; line-height: 12px;'>
                        Dla lepszego komfortu z korzystania tej strony, proszę zaktualizować przeglądarkę internetową.<br />
                        Używasz <?php echo $przegladarka ?> wersja <?php echo $wersja ?>
                    </div>
                </div>
                <div style='width: 75px; float: left;'>
                    <a href='http://www.firefox.pl' target='_blank'>
                        <?php echo $this->Html->image('Browser.firefox.png', array('alt' =>'Get Firefox!')); ?>
                    </a>
                </div>
                <div style='width: 75px; float: left;'>
                    <a href='http://www.browserforthebetter.com/download.html' target='_blank'>
                        <?php echo $this->Html->image('Browser.ie.png', array('alt' =>'Get IE!')); ?>
                    </a>
                </div>
                <div style='width: 73px; float: left;'>
                    <a href='http://www.apple.com/safari/download/' target='_blank'>
                        <?php echo $this->Html->image('Browser.safari.png', array('alt' =>'Get Safari!')); ?>
                    </a>
                </div>
                <div style='float: left;'>
                    <a href='http://www.google.com/chrome' target='_blank'>
                        <?php echo $this->Html->image('Browser.ie6nomore-chrome.jpg',array('alt' => 'Get Chrome!')); ?>
                    </a>
                </div>
            </div>
        </div>

    </div>  

    <?php     echo $this->Js->writeBuffer();
} ?>  