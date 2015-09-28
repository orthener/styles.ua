<div class="archiwum">
        <?php 
        $options = array();
        foreach ($newsByYears as $newsByYear){
            foreach ($newsByMonths[$newsByYear['year']] as $newsByMonth){
                $options[$newsByYear['year'].'.'.$newsByMonth['month']] = $months[$newsByMonth['month']].' '.$newsByYear['year'];
            }
        } 
            
    echo $this->Form->input('Filter.brand', array(
        'options' => $options,
        'selected' => empty($this->request->params['named']['m'])?'':$this->request->params['named']['y'].'.'.$this->request->params['named']['m'],
        'empty' => __d('front', 'wybierz miesiąc'),
        'label' => false,
    ));
?>
</div>
            
<script type="text/javascript">
    $('#FilterBrand').change(function(){
        var url = '<?php echo Router::url(array('plugin' => 'news', 'controller' => 'news', 'action' => 'index', 'type' => 'blog', 'page' => 1), true); ?>';
        if(typeof(this.value.split('.')[1]) != 'undefined'){
            document.location = url + '/y:' + this.value.split('.')[0] + '/m:' + this.value.split('.')[1];
        } else {
            document.location = url;
        }
            $('#FilterBrand').selectbox();
    });
</script>