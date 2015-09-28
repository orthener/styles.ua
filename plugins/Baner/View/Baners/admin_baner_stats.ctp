<?php
$this->Html->script(array('https://www.google.com/jsapi', 'jquery.blockui.js'), array('inline' => false));
?>
<div class="clearfix">
    <?php echo $this->element('dateRange', array(), array('plugin' => 'baner')); ?>
</div>

<style>
    .tooltipChart {
        float: right;
    }
</style>

<div style="height: 202px">
    <div class="tooltipChart">
        <?php echo $this->Form->input('banerlist', array('label' => 'Wybierz baner', 'options' => $baners, 'empty' => 'wszystkie...')); ?>
    </div>
</div>

<div id="chart_div"></div>

<script type="text/javascript">     
    blockAll("Proszę czekać, ładowanie bibioteki wykresu google");
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChartReady);
      
    function drawChartReady() {
        unblockAll();
        $('#widgetField>a').click();
    }
      
    function drawChart(dane) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Czas');
        data.addColumn('number', 'Wyświetlenia');
        data.addColumn('number', 'Kliknięcia');
        data.addRows(dane);

        var options = {
            backgroundColor: {
                stroke: '#666',
                strokeWidth: '20',
                fill: 'white'
            },
            height: 500,
            title: 'Wykreś wyświetleń / kliknięć banera w przedziale czasowym',
            vAxis: {
                title: 'Ilość wyświetleń banera', 
                titleTextStyle: {color: 'red'}
            },
            hAxis: {
                title: 'Oś czasu', 
                titleTextStyle: {color: 'red'} 
            }
        }

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
        
    
    $(function(){
        var akType = 1;
        var getChart = function(dane) {
                        
            blockAll("Trwa ladowanie wykresu");
            
            if (typeof(dane) == 'undefined') {
                var dane = {}
                dane['datePickerFrom'] = $('#datePickerFrom').attr('date');
                dane['dataPickerTo'] = $('#dataPickerTo').attr('date');
            }
            
            dane['banerId'] = $('#banerlist').val(); 
            dane['type'] = akType; 

            $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'baners', 'action' => 'get_chart_clicks')); ?>',
                dataType: 'json',
                type: "POST",
                data: dane,
                success: function(data) {
                    drawChart(data);
                    $('#widgetCalendar').css('height', 200);
                    unblockAll();
                }
            });
        }
        //init strony
        
        var objectDateFormated = $('#widgetCalendar').DatePickerGetDate(true);
        var objectDate = $('#widgetCalendar').DatePickerGetDate();
        
        $('#widgetField span').html(objectDateFormated.join(' &divide; '));
        
        getChart({
            datePickerFrom: '<?php echo date('Y-m-d', time()-60*60*24*30);?>',
            dataPickerTo: '<?php echo date('Y-m-d'); ?>'
        });
        
        $('#datePickerFrom').attr('date', objectDate[0]);
        $('#dataPickerTo').attr('date', objectDate[1]);

        $('#datePickerFrom').val(objectDateFormated[0]);
        $('#dataPickerTo').val(objectDateFormated[1]);
        
        
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
        $('#banerlist').bind('change', function(){
            getChart();        
        });
        
       
    })
</script>
<div class="actions">
	<h3><?php __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'New Baner'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__d('cms', 'List Baners'), array('action' => 'index'));?></li>
	</ul>
</div>