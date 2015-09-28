<div class="platnosci index">
<h2 class="noprint">Zestawienia faktur VAT</h2>

<?php 

    $month_last_day = date("t", strtotime($month_begin_timestamp)) + 0;
    setlocale(LC_TIME, 'pl_PL.UTF-8', 'pl.UTF-8', 'pol.UTF-8', 'polish');

?>




<style type="text/css">
/* <![CDATA[ */
 table tr td {
    padding: 1px;
 }
    table tr th.idColumn {
        width: 15px;
    }
 
 #content {
    line-height: 1.2;
    font-family: Arial, sans-serif;
 }
/* 
 div.dziecko-div div, div.dziecko-div table, div.dziecko-div tr, div.dziecko-div td, div.dziecko-div th { 
    page-break-after: avoid;
    page-break-before: avoid;
 }
 div.dziecko-div > div:last-child {
    page-break-after: auto;
 }
/* */

@media print {
    #menuPrincipal, 
    #header, 
    #footer, 
    .noprint,
    #nav,
    #leftMenu{
        display: none;
    }
    .clip #contentCms{
        width: 100%;
    }
    #content, #container {
        margin: 0;
        padding: 0;
        color: #000000;
    }

    .page-break-div { 
        page-break-after: always;
    }

/**/
}

/* ]]> */
</style>
<script type="text/javascript">
<!-- //<![CDATA[
    var pageBreakAfter = function (maxPageSize) {
        var i = 0;
        $j('.dziecko-div').removeClass('page-break-div');
        var elements = $j('.dzieci .dziecko-div');
        var n = elements.length
        while(i<n){
            var pageSize = 0;
        
            while(pageSize < maxPageSize && i<n){
                pageSize += $j(elements[i]).outerHeight();
                i++;
            }

            if(pageSize > maxPageSize){
                i--;
                $j(elements[i-1]).addClass('page-break-div');
            }
        
        }
    }
    
$j(document).ready(function(){
    pageBreakAfter(975);    
});
    
    
//]]> -->
</script>



<div class="noprint">
<?php

echo $this->Html->link('<< Poprzedni miesiąc', array('controller'=>'invoices','action'=>'month', date("Y/m", strtotime('-1 month', $month_begin_timestamp))));
echo ' &nbsp; &nbsp; ';
echo $this->Html->link('Następny miesiąc >>', array('controller'=>'invoices','action'=>'month', date("Y/m", strtotime('+1 month', $month_begin_timestamp))));

?> 
</div>

<?php 
$this->month_suma_netto = 0;
$this->month_suma_vat = 0;
$this->month_suma_brutto = 0;
foreach($invoicesGroups AS $key => $invoices){
    $info = ($invoices[0]['Invoice']['buyer_is_company'])?
        'Zestawienie faktur wystawionych na podmioty gospodarcze':
        'Zestawienie faktur wystawionych na osoby fizyczne nieprowadzące działajności gospodarczej';
    echo $this->element('invoices/month', array('invoices' => $invoices, 'number' => $key, 'info' => $info));
}

?>

<div class="invoices_legend noprint">
<p>Suma netto: <?php echo $febNumber->priceFormat($this->month_suma_netto); ?></td>
<p>Suma vat: <?php echo $febNumber->priceFormat($this->month_suma_vat); ?></td>
<p>Suma brutto: <?php echo $febNumber->priceFormat($this->month_suma_brutto); ?></td>
</div>

</div>

