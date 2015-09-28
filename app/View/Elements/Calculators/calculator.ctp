<?php echo $this->Html->css('CalcSelect2'); ?>

<h2><?php echo __('Kalkulator'); ?></h2>
<?php $shipment_options = explode(';', Configure::read('Calculator.FinalConstant')) ?>
<div class="calculator">
    <div class="row center">
        <span><?php echo __d('front', 'Podaj cenę w PLN'); ?></span>
        <span><?php echo $this->Form->input('pln_price', array('label' => false, 'placeholder' => '1.00', 'id' => 'pln_price')); ?></span>
    </div>
    <div class="row center">
        <span><?php echo __d('front', 'Wybierz dostawę w GRN'); ?></span>
        <span><?php echo $this->Form->input('shipment_price', array('label' => false, 'options' => $shipment_options)); ?></span>
    </div>
    <div class="row center">
        <span><?php echo __d('front', 'Cena w GRN'); ?></span>
        <span id="result"></span>
    </div>
    <div class="row">
        <span id="CalculatorFinalConstant" class="dn">W tym cena dostawy: <b></b></span>
        <span><?php echo $this->Form->submit(__d('front', 'Oblicz'), array('class' => 'btnGradientBlue', 'id' => 'btnCount')); ?></span>
    </div>

</div>
<script type="text/javascript">
    //<![CDATA[
    $('#shipment_price').select2({
        containerCssClass: 'calcSelect2',
        dropdownCssClass: 'dropDownCalcSelect2',
        minimumResultsForSearch: 5,
        width: '165px'
    });
    //]]>
</script>
<script>
    var gCalculatorFinalConstant = "<?php echo Configure::read('Calculator.FinalConstant'); ?>";
    /**
     * Funkcja uruchamia konwersję PLN/GRN
     */

    function countPln2Grn() {
        var plnPrice_val = $('#pln_price').val();
        var shipment_price = parseFloat($('#shipment_price option:selected').text());
        var tmp_price = parseFloat(plnPrice_val);
        var pln_price = parseFloat(tmp_price).toFixed(2);
        $.ajax({
            type: "post",
            url: '<?php echo $this->Html->url(array('controller' => 'calculators', 'action' => 'ajax_pln2grn', 'ext' => 'json')); ?>',
            dataType: 'json',
            data: {data: {pln_price: pln_price}},
            success: function(json) {
                json.grn_price = parseFloat(json.grn_price) + parseFloat(shipment_price);
//                console.log(shipment_price);
                var grn_price = float2currency(json.grn_price);
                $('#result').empty();
                $('#result').html(grn_price);
//                $('#CalculatorFinalConstant').removeClass('dn');
//                $('#CalculatorFinalConstant b').text(parseFloat(gCalculatorFinalConstant).toFixed(2).toString().replace('.', ','));
            }
        });
    }
    $('#btnCount').on('click', countPln2Grn);
    $(document).on('keyup', function(e) {
        if (e.keyCode == 13) {
            countPln2Grn();
        }
    });

    $('#shipment_price').change(function() {
        countPln2Grn();
    });

    /*
     * Funkcja zamienia wartość dziesiętną na wartość w walucie
     * np: 50.32 -> 50,32 PLN
     * @param my_float - wartość dziesiętna
     * @return zwraca wartość w walucie
     */
    function float2currency(my_float) {
        var tmp = "";
        if (my_float == 0) {
            tmp = "0,00";
        } else {
            if (my_float == parseFloat(my_float)) {
                tmp = parseFloat(my_float).toFixed(2);
                tmp = tmp.toString(); // + ",00";
            } else {
                tmp = my_float.toString();
            }
        }
        var currency = tmp.replace(".", ",");
        return currency; // + " GRN";
    }
</script>