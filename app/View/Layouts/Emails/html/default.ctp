<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head>
        <?php /* <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> */ ?>
        <title><?php echo $title_for_layout; ?></title>
    </head>
    <body>
    <style type="text/css">
        /* <![CDATA[ */
        p { margin: 0; }
        div.body { padding: 10px; background-color:white; }
        div.body, div.body p {
            font-family: Calibri, Arial, sans-serif;
            font-size: 11pt;
            color: #4f4f4f;
        }
        big { font-size: 13pt; }
        small, small a {
            color: #8d8d8d;
            font-size: 9pt;
        }
        /* ]]> */
    </style>
    <div class="body">
        <?php echo $content_for_layout; ?>
        <p>&nbsp;</p>
        <p>--</p>
        <em>С уважением, команда Styles.</em><br />
        <!--<p><?php // echo Configure::read('App.AppName'); ?></p><br />-->
        <p>Styles Group sp. z o.o.<br />
        ul. Trembeckiego 11A, <br />
        35-234 Rzeszów, Poland<br />
        <a href=http://styles.ua">http://styles.ua</a><br />
        <?php echo __d('public', 'Онлайн поддержка для Украины осуществляется через Skype: streetstyleshop'); ?><br /><br />
        </p>
        <p><img src="cid:logo.png" alt="<?php echo Configure::read('App.AppName'); ?>" /></p>
        <p><small><?php echo __('Wiadomość wygenerowana automatycznie - nie ma potrzeby na nią odpowiadać.'); ?></small></p>
    </div>
</body>
</html>
