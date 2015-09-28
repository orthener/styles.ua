
<?php echo $message['NewsletterMessage']['content']; ?>


<?php echo  __d('cms', 'Aby zrezygnować z newslettera należy kliknąć w poniższy link:'); ?>

<?php 
$link = $this->Html->url(array('admin' => false, 'controller'=>'newsletters','action'=>'delete',md5($email)),true);
echo $link;
?>