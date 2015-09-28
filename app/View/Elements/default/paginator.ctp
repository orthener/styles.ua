<div class="paging">
    <div>
        <?php echo __d('public', 'Strona ') .  ' ' . $this->Paginator->current() . ' ' . __d('public', ' z ') . ' ' . $this->Paginator->counter(array('format' => '%pages%')); ?>   
    </div>
    <?php echo $this->Paginator->prev('<', array(), null, array('class' => 'disabled')); ?>       
    <?php if ($this->Paginator->current() > 10 && !empty($this->request->params['plugin']) && $this->request->params['plugin'] == 'news') : ?>
        <span><a href="/blog">1</a></span>
        ... 
    <?php endif; ?>
    <?php echo $this->Paginator->numbers(array('separator' => null)); ?>
    <?php
    $lastPaginator = $this->Paginator->counter(array('format' => '%pages%'));
    if (($lastPaginator - 5) < $this->Paginator->current() or ($lastPaginator < 9)) {
        
    } else {
        echo '... ';
        echo $this->Paginator->last($lastPaginator, array(), null, array('class' => 'disabled'));
    }
    ?>
    <?php echo $this->Paginator->next('>', array(), null, array('class' => 'disabled')); ?>
</div>