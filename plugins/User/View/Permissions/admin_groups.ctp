<div>

<script type="text/javascript">
<!-- <![CDATA[
$(window).load(function(){
    $('#fixedHeightTbody').css('height', ($(window).height()-280)+'px');
});
//]]>-->
</script>

    <h2>Uprawnienia grup</h2>

    <?php echo $this->Form->create('Permission'); ?>

    <table style="width:auto;">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <?php $last_group = end($groups); ?>
                <?php foreach($groups AS $group){ ?>
                    <th><?php echo $group; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody id="fixedHeightTbody" style="height:300px; overflow-y:scroll; overflow-x:hidden">

        <?php foreach($permissionsNames AS $key => &$permission){ ?>
            <?php if(substr_compare($key, ':own', -4) === 0){ continue; }?>
            <tr>
                <th>
                <?php 
                    echo $key; 
                    echo isSet($permissionsNames[$key.':own'])?' / '.$key.':own':'';
                ?>
                </th>
                <?php foreach($groups AS $gr_key => $group){ ?>
                    <td <?php if($group == $last_group){ echo 'style="padding-right:20px"'; } ?> >
                        <?php 
                            echo $this->Form->checkbox($key.'-'.$gr_key, array(
                                'name' => 'data[Permission]['.$key.']['.$gr_key.']',
                                'checked' => (isSet($permission['Group'][$gr_key])?true:false)
                            )); 
                        ?>
                        <?php if(isSet($permissionsNames[$key.':own'])){ ?>
                            /
                        <?php 
                            echo $this->Form->checkbox($key.':own-'.$gr_key, array(
                                'name' => 'data[Permission]['.$key.':own]['.$gr_key.']',
                                'checked' => (isSet($permissionsNames[$key.':own']['Group'][$gr_key])?true:false)
                            )); 
                        ?>
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
        <?php echo $this->Form->input('Serialized.text', array('type' => 'textarea', 'label' => __d('cms', 'Import uprawnień grup'), 'cols' => '10', 'rows' => 2)); ?>
    <div>
        <?php echo $this->Form->submit('Zapisz'); ?>
    </div>
    <?php echo $this->Form->end(); ?>

</div>