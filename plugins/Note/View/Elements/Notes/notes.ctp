<?php foreach ($notes as $note): ?>
    <div id="notes-<?php echo $note['id'] ?>">
        <fieldset>
            <legend><b><?php echo isSet($users[$note['user_id']])?$users[$note['user_id']]:'---'; ?></b> 
                <?php
                if ($note['modified'] == $note['modified']) {
                    echo 'napisał';
                    $edited = $note['created'];
                } else {
                    echo 'zmodyfikował';
                    $edited = $note['modified'];
                }
                ?>
                <?php echo $this->FebTime->niceShort($edited); ?> <?php echo $this->Html->image('edit.png', array('url' => '#', 'title' => 'Edytuj Wiadomosc', 'class' => 'note-mod')); ?>
                <?php echo $this->Js->link($this->Html->image('delete.png'), array('controller' => 'notes', 'action' => 'delete', $note['id']), array('title' => 'Usuń', 'update' => '#notes-' . $note['id'], 'escape' => false, 'confirm' => __d('cms', 'Na pewno usunąć wiadomość?'))); ?>    
                <?php //echo $this->Html->image('comment.png', array('url' => '#', 'title' => 'Komentuj'));   ?>
            </legend>

            <div noteid="<?php echo $note['id'] ?>" class="note-content">
                <?php echo $note['content']; ?>
            </div>

        </fieldset>
    </div> 
<?php endforeach ?>

<?php echo $this->Js->writeBuffer(); ?>