<ul id="nav" class="clearfix">    
    <?php if ($this->Permissions->isAuthorized(array('plugin' => 'user', 'admin' => 'admin', 'controller' => 'users', 'action' => 'index'))) { ?>
        <li class="subNav"><a class="returnfalse" href="#" onclick="return false;"><?php echo __("ADMINISTRACJA"); ?></a>
            <ul>
                <?php echo $this->Permissions->link(__d('cms', 'Użytkownicy'), array('plugin' => 'user', 'admin' => 'admin', 'controller' => 'users', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
                <?php echo $this->Permissions->link(__d('cms', 'Grupy'), array('plugin' => 'user', 'admin' => 'admin', 'controller' => 'groups', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
                <?php echo $this->Permissions->link(__d('cms', 'Kategorie uprawnień'), array('plugin' => 'user', 'admin' => 'admin', 'controller' => 'permission_categories', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
                <?php echo $this->Permissions->link(__d('cms', 'Zarządzanie uprawnieniami'), array('plugin' => 'user', 'admin' => 'admin', 'controller' => 'permission_groups', 'action' => 'summary'), array('outter' => '<li>%s</li>')); ?>
            </ul>
        </li>
    <?php } ?>
    <li class="subNav">
        <?php echo $this->Permissions->link(__d('cms', 'Newsletter'), array('plugin' => 'newsletter', 'admin' => 'admin', 'controller' => 'newsletter_messages', 'action' => 'index')); ?>
        <ul>
            <?php echo $this->Permissions->link(__d('cms', 'Wiadomości'), array('plugin' => 'newsletter', 'admin' => 'admin', 'controller' => 'newsletter_messages', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Odbiorcy'), array('plugin' => 'newsletter', 'admin' => 'admin', 'controller' => 'newsletters', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        </ul>
    </li>
    <li class="subNav">
        <?php // echo $this->Permissions->link(__d('cms', 'Ustawienia'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'index')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Ustawienia'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'prefix', 'Shop')); ?>
        <ul>
            <?php echo $this->Permissions->link(__('магазин'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'prefix', 'Shop'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Studio'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'prefix', 'Studio'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__('Strona'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'prefix', 'App'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__('Znaczniki Meta'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'prefix', 'Meta'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__('Reklamy na stronach głównych'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'prefix', 'Ad'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__('Kalkulator konwersji PLN/GRN'), array('plugin' => 'page', 'admin' => 'admin', 'controller' => 'pages', 'action' => 'edit', 28), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__('Kalkulator konwersji PLN/GRN parametry'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'prefix', 'Calculator'), array('outter' => '<li>%s</li>')); ?>
            <?php //echo $this->Permissions->link(__('K-Ex'), array('plugin' => 'setting', 'admin' => 'admin', 'controller' => 'settings', 'action' => 'prefix', 'Kex'), array('outter' => '<li>%s</li>')); ?>
        </ul>
    </li>
    <li class="subNav">
        <?php echo $this->Permissions->link(__('Produkty'), array('plugin' => 'static_product', 'admin' => 'admin', 'controller' => 'products', 'action' => 'index')); ?>
        <ul>
            <?php echo $this->Permissions->link(__('Lista produktów'), array('plugin' => 'static_product', 'admin' => 'admin', 'controller' => 'products', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__('Kategorie produktów'), array('plugin' => 'static_product', 'admin' => 'admin', 'controller' => 'products_categories', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        </ul>
    </li>
    <li class="subNav">
        <?php echo $this->Html->link(__d('cms', 'Blog'), '#'); ?>
        <ul>
            <?php echo $this->Permissions->link(__d('cms', 'Kategorie'), array('plugin' => 'news', 'admin' => 'admin', 'controller' => 'news_categories', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Wpisy'), array('plugin' => 'news', 'admin' => 'admin', 'controller' => 'news', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Komentarze do moderacji'), array('plugin' => 'comment', 'admin' => 'admin', 'controller' => 'comments', 'action' => 'index', 0), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Komentarze zaakceptowane'), array('plugin' => 'comment', 'admin' => 'admin', 'controller' => 'comments', 'action' => 'index', 1), array('outter' => '<li>%s</li>')); ?>
            <?php // echo $this->Permissions->link(__d('cms', 'Komentarze2'), array('plugin' => 'comment', 'admin' => 'admin', 'controller' => 'comments', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php //echo $this->Permissions->link(__d('cms', 'Tagi'), array('plugin' => 'info', 'admin' => 'admin', 'controller' => 'info_tags', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php //echo $this->Permissions->link(__d('cms', 'Banery reklamowe'), array('plugin' => 'info', 'admin' => 'admin', 'controller' => 'info_adbaners', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php //echo $this->Permissions->link(__d('cms', 'Banery reklamowe - statystyki'), array('plugin' => 'info', 'admin' => 'admin', 'controller' => 'info_adbaners_stats', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        </ul>
    </li>
    <li class="subNav">
        <?php echo $this->Permissions->link(__d('cms', 'Studio'), array('plugin' => 'studio', 'admin' => 'admin', 'controller' => 'studio_movies', 'action' => 'index')); ?>
        <ul>
            <?php echo $this->Permissions->link(__d('cms', 'Media'), array('plugin' => 'studio', 'admin' => 'admin', 'controller' => 'studio_movies', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        </ul>
    </li>
    <li class="subNav">
        <?php echo $this->Permissions->link(__d('cms', 'Slider'), array('plugin' => 'slider', 'admin' => 'admin', 'controller' => 'sliders', 'action' => 'index')); ?>
        <ul>
            <?php echo $this->Permissions->link(__d('cms', 'Lista slajdów'), array('plugin' => 'slider', 'admin' => 'admin', 'controller' => 'sliders', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            <?php echo $this->Permissions->link(__d('cms', 'Dodaj nowy slide'), array('plugin' => 'slider', 'admin' => 'admin', 'controller' => 'sliders', 'action' => 'add'), array('outter' => '<li>%s</li>')); ?>
        </ul>
    </li>

    <!--    <li class="subNav">
    <?php // echo $this->Html->link(__d('cms', 'Artykuły'), '#'); ?>
            <ul>
    <?php // echo $this->Permissions->link(__d('cms', 'Kategorie'), array('plugin' => 'info', 'admin' => 'admin', 'controller' => 'info_categories', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    <?php // echo $this->Permissions->link(__d('cms', 'Artykuły'), array('plugin' => 'info', 'admin' => 'admin', 'controller' => 'info_pages', 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
            </ul>        
        </li>-->
    <li class="subNav">
        <?php echo $this->Permissions->link(__d('cms', 'System zamówień'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'index')) ?>
        <ul>
            <?php echo $this->Permissions->link(__d('cms', 'Lista zamówień w trakcie realizacji'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'index', 1), array('outter' => '<li>%s</li>')) ?>
            <?php echo $this->Permissions->link(__d('cms', 'Lista zamówień zrealizowanych'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'index', 2), array('outter' => '<li>%s</li>')) ?>
            <?php echo $this->Permissions->link(__d('cms', 'Lista zamówień anulowanych'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'index_cancel'), array('outter' => '<li>%s</li>')) ?>
            <?php // echo $this->Permissions->link('Osoby polecające', array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'order_references', 'action' => 'index'), array('outter' => '<li>%s</li>')) ?>
            <?php echo $this->Permissions->link(__d('cms', 'Program partnerski'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'affiliate_programs', 'action' => 'index'), array('outter' => '<li>%s</li>')) ?>
            <?php echo $this->Permissions->link(__d('cms', 'Klienci'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'customers', 'action' => 'index'), array('outter' => '<li>%s</li>')) ?>
            <?php echo $this->Permissions->link(__d('cms', 'Cennik kosztów wysyłki'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'shipment_methods', 'action' => 'index'), array('outter' => '<li>%s</li>')) ?>
            <?php echo $this->Permissions->link(__d('cms', 'Statusy zamówienia'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'order_statuses', 'action' => 'index'), array('outter' => '<li>%s</li>')) ?>
            <?php echo $this->Permissions->link(__d('cms', 'Kody promocyjne'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'promotion_codes', 'action' => 'index'), array('outter' => '<li>%s</li>')) ?>
        </ul>
    </li>
    <li class="subNav"><?php echo $this->Permissions->link(__d('cms', 'Marki'), array('plugin' => 'brand', 'admin' => 'admin', 'controller' => 'brands', 'action' => 'index')) ?></li>
    <li class="subNav"><?php echo $this->Permissions->link(__d('cms', 'Raporty sprzedaży'), array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'report', 1)) ?></li>
    <li class="subNav"><?php // echo $this->Html->link('Banery', array('plugin' => 'baner', 'admin' => 'admin', 'controller' => 'baners', 'action' => 'index', 1))    ?></li>

    <?php //echo $this->element('Searcher.Searchers/menu'); ?>
</ul>
<!--</li>-->
<!--<li class="subNav"><?php // echo $this->Html->link('Raporty sprzedaży', array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'report', 1))    ?></li>-->
<!--<li class="subNav"><?php // echo $this->Html->link('Banery', array('plugin' => 'baner', 'admin' => 'admin', 'controller' => 'baners', 'action' => 'index', 1))     ?></li>-->

<?php //echo $this->element('Searcher.Searchers/menu'); ?>
<!--</ul>-->

