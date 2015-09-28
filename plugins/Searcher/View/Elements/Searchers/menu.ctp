<div id="searcherContent">
    <?php echo $this->Html->script('jquery.blockui', array('inline' => true)); ?>
    <?php echo $this->Form->input('searcher', array('label' => "Wyszukiwarka")); ?>

    <script type="text/javascript">
        var canSearch = true;
        $(':not(#searcher)').click(function(evt){
            if ($('#searcher').val() == "") {
                $('#searcher').animate({
                    width: '100'
                });
                evt.stopPropagation();
            }
        });
        
        $('#searcher').click(function(evt){
            $('#searcher').animate({
                width: '200'
            });
            evt.stopPropagation();
        });
        
        var lockSearch = function(){
            canSearch = false;
        }
        
        //Na razie tylko po entrze
        $('#searcher').keydown(function(evt){
             if (evt.keyCode == "13") {
                 canSearch = true;
                 reloadTable($(this).val());
             }
//            if ($(this).val().length > 1) {
//                reloadTable($(this).val());
//                canSearch = false;
//            }
//            if (!canSearch) {
//                setTimeout("lockSearch()", 100);
//            }
            evt.stopPropagation();
        });
        
        $('#searcher').change(function(evt){
            if (!canSearch) {
                canSearch = true;
                if ($(this).val().length > 1) {
                    reloadTable($(this).val());
                }
            }
            evt.stopPropagation();
        });
        
        var reloadTable = function(data) {
            if (canSearch) {
                $('#contentCms').animate({opacity: '.5'});
                $.ajax({
                    url: '<?php echo $this->Html->url(array('admin' => 'admin', 'plugin' => 'searcher', 'controller' => 'searchers', 'action' => 'search')); ?>',
                    dataType: 'html',
                    data: {'data': {
                            'fraz': data,
                            'currentController': '<?php echo $this->params['controller']; ?>'
                        }
                    },
                    type: "POST",
                    success: function(data) {
                        $('#contentCms').html(data);
                        $('#contentCms').animate({opacity: '1'});
                    }
                });
            }
        }
    </script>
</div>