<div class="paging">
    <?php echo $this->Paginator->prev('<', array(), null, array('class'=>'disabled'));?>
        <?php echo $this->Paginator->numbers(array('separator'=>null));?>
        <?php 
        
        $lastPaginator=$this->Paginator->counter(array('format'=>'%pages%'));
        if(($lastPaginator-5)<$this->Paginator->current() or ($lastPaginator<9)){
        }else{
          echo '... ';
          echo $this->Paginator->last($lastPaginator, array(), null, array('class'=>'disabled'));  
        }
        
        
        ?>
    <?php echo $this->Paginator->next('>', array(), null, array('class'=>'disabled'));?>
</div>