<script>
    $(function(){
        setTimeout(function(){
            document.location = <?php echo Router::url(array('conditions' => 'users', 'action' => 'login_facebook')); ?>;
        }, 5000);
    });
    
</script>
<h1><span><?php __d('cms', 'Konto zostało utworzone'); ?></span></h1>
<p style="padding:6px 2px;">
<?php __d('cms', 'Dziękujemy za rejestrację.'); ?>
</p>
<p style="padding:6px 2px;font-size:14px">
<?php __d('cms', 'Za chwile zostaniesz zalogowany. Nie chcesz czekac? '); ?> <?php echo $this->Html->link('Zaloguj!', array('conditions' => 'users', 'action' => 'login_facebook')); ?>
    
    
    
</p>
