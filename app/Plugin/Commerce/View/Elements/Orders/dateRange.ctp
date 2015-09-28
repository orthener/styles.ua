<?php
$this->Html->script('DatePicker/datepicker', array('inline' => false));
$this->Html->script('DatePicker/eye', array('inline' => false));
//$this->Html->script('DatePicker/utils', array('inline' => false));
$this->Html->css('DatePicker/datepicker', null, array('inline' => false));
$this->Html->css('DatePicker/layout', null, array('inline' => false));
?>

<div id="widget" class="datePickerContent">
    <div id="widgetField">
        <span></span>
        <a href="#">Select date range</a>
    </div>
    <div id="widgetCalendar">
    </div>
</div>

<script type="text/javascript">      
    
    (function($){
        var initLayout = function() {
            var state = false;
            $('#widgetCalendar').DatePicker({
                flat: true,
                format: 'd B, Y',
                date: [new Date('<?php echo date('Y-m-d', time()-60*60*24*30); ?>'), new Date()],
                calendars: 3,
                mode: 'range',
                starts: 1,
                onChange: function(formated, objectDate) {
                    $('#widgetField span').html(formated.join(' &divide; '));
                    
                    $('#datePickerFrom').attr('date', objectDate[0]);
                    $('#dataPickerTo').attr('date', objectDate[1]);
                    
                    $('#datePickerFrom').val(formated[0]);
                    $('#dataPickerTo').val(formated[1]);
                    $('#widgetCalendar').css('height', 200); 
                }
            });
            $('#widgetField>a').bind('click', function() {
                $('#widgetCalendar').stop().animate({height: state ? 0 : $('#widgetCalendar div.datepicker').get(0).offsetHeight}, 500);
                state = !state;
                return false;
            });

        };
        EYE.register(initLayout, 'init');
    })(jQuery)
</script>
