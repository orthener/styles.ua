<div class="permissions form">
<h2>
    <?php 
        switch($this->Form->value('RequestersPermission.model')){
            case 'Group':
                echo __d('cms', 'Nowe uprawnienie dla grupy: %s', $record['Group']['name']);
                break;
            case 'User':
                echo __d('cms', 'Nowe uprawnienie dla użytkownika: %s', $record['User']['email']);
                break;
            default:
                echo __d('cms', 'Uprawnienie definiowane na poziomie modelu: %s, dla rekordu: %s', $this->Form->value('RequestersPermission.model'), $record[$this->Form->value('RequestersPermission.model')]['name']);
                break;
        }
    ?>
</h2>
<?php echo $this->Form->create('Permission');?>
	<fieldset>
 		<legend><?php echo __d('cms', 'Dodaj %s', 'uprawnienie'); ?></legend>
	<?php
		echo $this->Form->hidden('RequestersPermission.model');
		echo $this->Form->hidden('RequestersPermission.row_id');
		echo $this->Form->input('RequestersPermission.permission_id', array('label' => 'Wybierz zasób', 'empty' => 'Wybierz zasób z listy, lub wpisz w poniższe pole'));
		echo $this->Form->input('Permission.name', array('label' => 'Wprowadź zasób'));
	?>
	<div>
        <pre>
Możliwe zasoby (podlegające kontroli uprawnień)
 * - pełne uprawnienia dla administratora
 nazwa_kontrolera:* - pełny dostęp w obrębie kontrolera
 nazwa_kontrolera:nazwa_akcji - dostęp do wybranej akcji
 nazwa_kontrolera:nazwa_akcji:id_rekordu - dostęp do konkrenego rekordu z tabeli na poziomie wybranej akcji
 nazwa_modelu:id_rekordu - pełny dostęp do wybranego rekordu (użytkownik ma dostęp do edycji, usuwania itd.)
 nazwa_kontrolera:nazwa_akcji:own - dostęp do wybranej akcji, tylko do własnych rekordów (np. users:edit:own - użytkownik może edytować własny profil)
        </pre>
    </div>
	</fieldset>
<?php echo $this->Form->end(__d('cms', 'Zapisz'));?>
</div>
