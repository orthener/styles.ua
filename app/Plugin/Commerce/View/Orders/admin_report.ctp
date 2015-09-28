<?php $this->Html->script(array('https://www.google.com/jsapi', 'jquery.blockui.js', 'jquery.datepick/jquery.datepick', 'jquery.datepick/jquery.datepick-pl'), array('inline' => false)); ?>

<?php $this->Html->css('/commerce/css/commerce', null, array('inline' => false)); ?>
<?php $this->Html->css('jquery.datapick/ui-cupertino.datepick.css', null, array('inline' => false)); ?>
<?php $this->Html->css('jquery.datapick/jquery.datepick.css', null, array('inline' => false)); ?>

<h2><?php echo __d('cms', 'Raporty sprzedaży');?></h2>

<div class="clearfix">
    <div class="tooltipChart">
        <?php
        $options['count'] = __d('cms', "Ilość zrealizowanych zamówień");
        $options['value'] = __d('cms', "Wartość zrealizowanych zamówień");

        echo $this->Form->input('Typ', array('type' => 'select', 'options' => $options, 'label' => 'Typ wykresu', 'div' => array('id' => 'chartType')));
        echo $this->Form->button(__d('cms', 'Wykres dzienny'), array('id' => 'datePickerDayButton'));
        echo $this->Form->button(__d('cms', 'Wykres miesięczny'), array('id' => 'datePickerMonthButton'));
        echo $this->Form->button(__d('cms', 'Wykres roczny'), array('id' => 'datePickerYearButton'));
        ?>

    </div>
    <div id="DatePickerContent" style="font-size: 13.5px; line-height: 1.1"></div>
</div>


<div id="chart_div"></div>
<div id="table_div"></div>

<script type="text/javascript">     
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChartReady);
      
    var mainFromDate = "";
    var mainToDate = "";
      
      
    function drawChartReady() {
//        unblockAll();
    }
      
    function drawChart(dane) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Czas');
        data.addColumn('number', dane.config.vAxis);
        data.addRows(dane.dane);


        var options = {
            backgroundColor: {
                stroke: '#666',
                strokeWidth: '20',
                fill: 'white'
            },
            height: 500,
            title: '<?php echo __d('cms', 'Raporty sprzedaży')?> - ' +dane.config.title,
            vAxis: {
                title: dane.config.vAxis, 
                titleTextStyle: {color: 'red'}
            },
            hAxis: {
                title: '<?php echo __d('cms', 'Oś czasu'); ?>', 
                titleTextStyle: {color: 'red'} 
            }
        }

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
        
    $(function(){
        var akType = 1;
        var getChart = function(dane) {
            
            if (typeof(dane) == 'undefined') {
                var dane = {};
                dane['datePickerFrom'] = mainFromDate;
                dane['dataPickerTo'] = mainToDate;
            }
            
//            blockAll("Trwa ładowanie wykresu");
 
            dane['type'] = akType; 
            dane['typeChart'] = $('#Typ').val();
            
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'orders', 'action' => 'orders_stats')); ?>',
                dataType: 'json',
                type: "POST",
                data: dane,
                success: function(data) {
                    drawChart(data);
                    tableCreate(data);
//                    unblockAll();
                }
            });
        }
        
        //init strony
        
//        getChart({
//            datePickerFrom: mainFromDate,
//            dataPickerTo: mainToDate
//        });
//                
        
        $('#datePickerDayButton').bind('click', function(){
            akType = 1;
            getChart();            
        });
        $('#datePickerMonthButton').bind('click', function(){
            akType = 2;
            getChart();        
        });
        $('#datePickerYearButton').bind('click', function(){
            akType = 3;
            getChart();        
        });
        $('#Typ').bind('change', function(){
            getChart();        
        });
        
        $('#DatePickerContent').datepick({ 
            rangeSelect: true, 
            monthsToShow: 3, 
            defaultDate: '-1m',
            showTrigger: '#calImg',
            onSelect: function(dates) { 
                var fromDate = $.datepick.formatDate(dates[0]); 
                var toDate = $.datepick.formatDate(dates[1]); 
                    
                if (fromDate != toDate) {
                    mainFromDate = fromDate
                    mainToDate = toDate;
                    getChart({
                        datePickerFrom: fromDate,
                        dataPickerTo: toDate
                    });
                } else {
                    mainFromDate = '';
                    mainToDate = '';
                }  
                return true;
            } 
        }); 
    });
</script>
<!-- Funkcje dla tabeli sprzedaży -->
<script>
    /**
     * Funkcja generuje tabelę zestawienia zamówień
     * @param {type} _data
     * @returns {undefined}
     */
    function tableCreate(_data) {
        $('#table_div').empty();
        $('#table_div').append('<table cellspacing="0" cellpadding="0"></table>');
        $('#table_div table').append('<thead><tr><th><?php echo __d('cms', 'Okres rozliczeniowy');?></th><th>' + _data.config.vAxis + '</th></tr></thead>');
        $('#table_div table').append('<tbody></tbody>');
        
        for(var i = 0; i < _data.dane.length; i++) {
            var time = _data.dane[i][0];
            var ilosc = _data.dane[i][1];
            $('#table_div table tbody').append('<tr><td>' + time + '</td><td>' + ilosc + '</td></tr>');
        }
    }
</script>