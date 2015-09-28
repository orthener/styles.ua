<?php echo $this->Html->css('/commerce/css/commerce'); ?>
<script type="text/javascript">
    //jQuery TinyMC
    (function(b){var e,d,a=[],c=window;b.fn.tinymce=function(j){var p=this,g,k,h,m,i,l="",n="";if(!p.length){return p}if(!j){return tinyMCE.get(p[0].id)}p.css("visibility","hidden");function o(){var r=[],q=0;if(f){f();f=null}p.each(function(t,u){var s,w=u.id,v=j.oninit;if(!w){u.id=w=tinymce.DOM.uniqueId()}s=new tinymce.Editor(w,j);r.push(s);s.onInit.add(function(){var x,y=v;p.css("visibility","");if(v){if(++q==r.length){if(tinymce.is(y,"string")){x=(y.indexOf(".")===-1)?null:tinymce.resolve(y.replace(/\.\w+$/,""));y=tinymce.resolve(y)}y.apply(x||tinymce,r)}}})});b.each(r,function(t,s){s.render()})}if(!c.tinymce&&!d&&(g=j.script_url)){d=1;h=g.substring(0,g.lastIndexOf("/"));if(/_(src|dev)\.js/g.test(g)){n="_src"}m=g.lastIndexOf("?");if(m!=-1){l=g.substring(m+1)}c.tinyMCEPreInit=c.tinyMCEPreInit||{base:h,suffix:n,query:l};if(g.indexOf("gzip")!=-1){i=j.language||"en";g=g+(/\?/.test(g)?"&":"?")+"js=true&core=true&suffix="+escape(n)+"&themes="+escape(j.theme)+"&plugins="+escape(j.plugins)+"&languages="+i;if(!c.tinyMCE_GZ){tinyMCE_GZ={start:function(){tinymce.suffix=n;function q(r){tinymce.ScriptLoader.markDone(tinyMCE.baseURI.toAbsolute(r))}q("langs/"+i+".js");q("themes/"+j.theme+"/editor_template"+n+".js");q("themes/"+j.theme+"/langs/"+i+".js");b.each(j.plugins.split(","),function(s,r){if(r){q("plugins/"+r+"/editor_plugin"+n+".js");q("plugins/"+r+"/langs/"+i+".js")}})},end:function(){}}}}b.ajax({type:"GET",url:g,dataType:"script",cache:true,success:function(){tinymce.dom.Event.domLoaded=1;d=2;if(j.script_loaded){j.script_loaded()}o();b.each(a,function(q,r){r()})}})}else{if(d===1){a.push(o)}else{o()}}return p};b.extend(b.expr[":"],{tinymce:function(g){return g.id&&!!tinyMCE.get(g.id)}});function f(){function i(l){if(l==="remove"){this.each(function(n,o){var m=h(o);if(m){m.remove()}})}this.find("span.mceEditor,div.mceEditor").each(function(n,o){var m=tinyMCE.get(o.id.replace(/_parent$/,""));if(m){m.remove()}})}function k(n){var m=this,l;if(n!==e){i.call(m);m.each(function(p,q){var o;if(o=tinyMCE.get(q.id)){o.setContent(n)}})}else{if(m.length>0){if(l=tinyMCE.get(m[0].id)){return l.getContent()}}}}function h(m){var l=null;(m)&&(m.id)&&(c.tinymce)&&(l=tinyMCE.get(m.id));return l}function g(l){return !!((l)&&(l.length)&&(c.tinymce)&&(l.is(":tinymce")))}var j={};b.each(["text","html","val"],function(n,l){var o=j[l]=b.fn[l],m=(l==="text");b.fn[l]=function(s){var p=this;if(!g(p)){return o.apply(p,arguments)}if(s!==e){k.call(p.filter(":tinymce"),s);o.apply(p.not(":tinymce"),arguments);return p}else{var r="";var q=arguments;(m?p:p.eq(0)).each(function(u,v){var t=h(v);r+=t?(m?t.getContent().replace(/<(?:"[^"]*"|'[^']*'|[^'">])*>/g,""):t.getContent()):o.apply(b(v),q)});return r}}});b.each(["append","prepend"],function(n,m){var o=j[m]=b.fn[m],l=(m==="prepend");b.fn[m]=function(q){var p=this;if(!g(p)){return o.apply(p,arguments)}if(q!==e){p.filter(":tinymce").each(function(s,t){var r=h(t);r&&r.setContent(l?q+r.getContent():r.getContent()+q)});o.apply(p.not(":tinymce"),arguments);return p}}});b.each(["remove","replaceWith","replaceAll","empty"],function(m,l){var n=j[l]=b.fn[l];b.fn[l]=function(){i.call(this,l);return n.apply(this,arguments)}});j.attr=b.fn.attr;b.fn.attr=function(n,q,o){var m=this;if((!n)||(n!=="value")||(!g(m))){return j.attr.call(m,n,q,o)}if(q!==e){k.call(m.filter(":tinymce"),q);j.attr.call(m.not(":tinymce"),n,q,o);return m}else{var p=m[0],l=h(p);return l?l.getContent():j.attr.call(b(p),n,q,o)}}}})(jQuery);
    //    
    $(function(){
        $('#email-content').tinymce({
            height : '580',
            width: '697',
            script_url : '<?php echo $this->Html->url('/js/tiny_mce/tiny_mce.js'); ?>',
            language : 'pl',
            mode : 'textareas',
            theme : 'simple',
            theme_advanced_buttons1 : 'bold,italic,underline,strikethrough',
            theme_advanced_toolbar_location : 'top',
            theme_advanced_resizing: true,
            //            save_callback : "myCustomSaveContent",
            plugins : "noneditable"
        });
        
        $('#email-content').val($('#hiden-tiny-content').html());     
        $('email-msg').css('color', 'grey');
        
    });

</script>

<?php echo $this->Form->create(); ?>
<fieldset>
    <legend><?php echo __('Powiadomienie do klienta (Email)'); ?></legend>
    <?php
    echo $this->Form->input('id', array('value' => $order['Order']['id']));
    echo $this->Form->input('Od', array('label' => __d('cms', 'Nadawca'), 'readonly' => 'readonly'));
    echo $this->Form->input('Do', array('label' => __d('cms', 'Odbiorca'), 'readonly' => 'readonly'));
    echo $this->Form->input('subject', array('label' => __d('cms', 'Temat'), 'value' => __d('cms', 'Informacje o realizacji zamówienia nr #') . ' ' . $order['Order']['hash']));
    echo $this->Form->input('content', array('div' => false, 'label' => false, 'id' => 'email-content', 'type' => 'textarea'));
    echo $this->Form->end(__('Wyślij'));
    echo $this->Html->link(__('Nie Wysyłaj'), array('action' => 'index'), array('class' => 'button noSendClient'));
    ?>


</fieldset>

<?php //debug($order); ?>

<div id="hiden-tiny-content" style="display: none;">

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
        <div id="content-for-layout">
            <?php echo __d('cms', 'Witaj'); ?>,<br /><?php echo __d('cms', 'Twoje zamówienie zostało zaktualizowane. Szczególy zamówienia możesz sprawdzić poniżej'); ?>:
            =====================<br />

            <b><?php echo __d('cms', 'Status'); ?>:</b> <?php echo isset($order['OrderStatus']['name']) ? $order['OrderStatus']['name'] : 'Nie znany' ?><br />

            <?php if ($order['Order']['order_status_id'] >= 50 && !empty($order['ShipmentMethod']['track_link'])) { // Jeżeli jest to kurier tnt albo gls ?>
                <?php if ($order['ShipmentMethod']['id'] == 4) { ?>
                    <?php echo __d('cms', 'Przesyłkę można śledzić pod adresem'); ?>: <?php echo $this->Html->link($order['ShipmentMethod']['name'] . ' śledzenie przesyłki', $order['ShipmentMethod']['track_link'] . $order['Order']['track_number'], array('target' => "_blank")); ?><br /><br />        
                <?php } else { ?>
                            <?php echo __d('cms', 'Przesyłkę można śledzić pod adresem'); ?>: <?php echo $this->Html->link($order['ShipmentMethod']['name'] . ' śledzenie przesyłki', $order['ShipmentMethod']['track_link'], array('target' => "_blank")); ?>, wpisując numer przesyłki: <b><?php echo $order['Order']['track_number']; ?></b> <br /><br />
                <?php } ?>
            <?php } ?>

            <?php if (!empty($order['Payment'])) { ?>
                <b>Płatności:</b><br />
                <ul>
                    <?php foreach ($order['Payment'] as $k => $payment) { ?>
                        <li><?php echo $payment['payment_gate']; ?> - <?php echo $this->FebNumber->priceFormat($payment['amount']); ?> - <?php echo $statuses[$payment['status']]; ?> <?php echo $payment['payment_date']; ?> </li>
                    <?php } ?>
                </ul>
            <?php } ?>

                
            <?php $shipmentTemp = Commerce::calculateByPriceType($order['Order']['shipment_price'], $order['Order']['shipment_tax_rate'], 1, $order['Order']['shipment_discount']); ?>
            <?php if (isSet($shipmentMethods[$order['Order']['shipment_method_id']])) { ?>    
                <b><?php echo __d('cms', 'Dostawa'); ?></b>: <?php echo $shipmentMethods[$order['Order']['shipment_method_id']]; ?> - <?php echo $this->Number->currency($shipmentTemp['price_gross'],'PLN'); ?> <br /> 
            <?php } ?>
                <b><?php echo __d('cms', 'Szczegóły zamówienia'); ?>:</b><br />
            <ul>
                <?php foreach ($order['OrderItem'] as $product): ?>

                    <?php $pTempQuatity = Commerce::calculateByPriceType($product['price'], $product['tax_rate'], $product['quantity'], $product['discount']) ?>
                    <?php $pTemp = Commerce::calculateByPriceType($product['price'], $product['tax_rate'], 1, $product['discount']) ?>
                    <li><?php echo $product['name'] ?> <?php echo $this->Number->currency($pTemp['final_price_gross'], 'PLN'); ?> x <?php echo $product['quantity'] ?> = <?php echo $this->Number->currency($pTempQuatity['final_price_gross'],'PLN'); ?>
                        <?php if (!empty($product['desc'])) { ?>
                            <br />
                            <i>(<?php echo $product['desc']; ?>)</i>
                        <?php } ?>
                        <?php
                        if (!empty($product['OrderItemFile'])) {
                            foreach ($product['OrderItemFile'] as $k => $orderItemFile) {
                                if ($orderItemFile['accepted'] == 2) {
                                    //Projekt Zakceptowany 
                                    ?>
                                    <br />
                                    <span style='color: red'><b><?php echo $orderItemFile['name']; ?></b> - Brak Akceptacji!</span>
                                    <br />
                                    <?php if (!empty($orderItemFile['desc'])) { ?>
                                        <i>(<?php echo $orderItemFile['desc']; ?></i>)
                                    <?php } ?>
                                    <?php
                                } elseif ($orderItemFile['accepted'] == 1) {
                                    //Projekt 
                                    ?>
                                    <br />
                                    <span style='color: green'><b><?php echo $orderItemFile['name']; ?></b> - zaakceptowany</span>
                                    <br />
                                    <?php if (!empty($orderItemFile['desc'])) { ?>
                                        <i>(<?php echo $orderItemFile['desc']; ?></i>)
                                    <?php } ?>
                                    <?php
                                } elseif ($orderItemFile['accepted'] == 0) {
                                    //W trakcie akceptacji
                                }
                            }
                        }
                        ?>
                    </li>
                <?php endforeach ?>
            </ul>    

            <?php $summary = Commerce::getTotalPricesForOrder($order); ?>

            <b><?php echo __d('cms', 'RAZEM'); ?></b> (<?php echo __d('cms', 'z kosztami wysyłki'); ?>): <?php echo $this->Number->currency($summary['final_price_gross'], 'PLN') ?><br />
            <b><?php echo __d('cms', 'Zapłacono'); ?>:</b> <?php echo $this->Number->currency($paymentTotal, 'PLN'); ?><br />
            <b><?php echo __d('cms', 'Pozostało'); ?>:</b> <?php echo ($summary['final_price_gross'] - $paymentTotal) >= 0 ? $this->Number->currency($summary['final_price_gross'] - $paymentTotal, 'PLN') : __d('cms', 'Nadplata ') . $this->Number->currency($summary['final_price_gross'] - $paymentTotal, 'PLN'); ?><br />
            =====================<br />
        </div>
    </div>
</div>

<!--<script type="text/javascript">
//    function myCustomSaveContent(element_id, html, body) {
//        object = jQuery( html );
//        object = object[2];
//       
//        return jQuery(object).find('#content-for-layout').html();
//    } 
</script>-->