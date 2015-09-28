<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo __d('cms', 'Nazwa uprawnienia'); ?></th>
        <th><?php echo __d('cms', 'Akcja'); ?></th>
    </tr>
    <?php foreach ($permissions as $permission): ?>
        <tr data-id="<?php echo $permission['Permission']['id']; ?>">
            <td><?php echo $permission['Permission']['name']; ?>&nbsp;</td>
            <td class="permissionActions">
                <?php echo $this->Html->link(__d('cms', 'Usuń uprawnienie'), array('controller' => 'permissions','action' => 'disgroup', $permission['Permission']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<script type="text/javascript">
    $(function(){
        console.debug($('.permissionActions a'));
        $('.permissionActions a').click(function(e){
            var $this = $(this);
            $.ajax({
                url: $this.attr('href'),
                success: function() {
                    $this.parents('tr').hide();
                }
            });
            e.preventDefault();
        });        
    });
</script>