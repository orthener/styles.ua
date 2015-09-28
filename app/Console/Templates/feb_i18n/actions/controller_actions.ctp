<?php
/**
 * Bake Template for Controller action generation.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.actions
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
    /**
    * Akcja wyświetlająca listę obiektów
    * 
    * @return void
    */
	public function <?php echo $admin ?>index() {
        $this->helpers[] = 'FebTime';
        <?php if(!$admin){ ?>
    		$this-><?php echo $currentModelName ?>->recursive = 0;
        <?php } else {?>
        	$this-><?php echo $currentModelName ?>->recursive = 1;
            $this-><?php echo $currentModelName ?>->locale = Configure::read('Config.languages');
            $this-><?php echo $currentModelName ?>->bindTranslation(array($this-><?php echo $currentModelName ?>->displayField => 'translateDisplay'));
        <?php } ?>
		$this->set('<?php echo $pluralName ?>', $this->paginate());
	}

    /**
    * Akcja podglądu obiektu
    *
    * @param string $id
    * @return void
    */
	public function <?php echo $admin ?>view($id = null) {
<?php if (!$admin): ?>
//        $slug = $this-><?php echo $currentModelName; ?>->isSlug($slug);
//        if (!$slug) {
//            throw new NotFoundException(__('Strona nie istnieje.'));
//        }
//        if (!empty($slug['error'])) {
//            $this->redirect(array($slug['slug']), $slug['error']);
//        }
//        $this-><?php echo $currentModelName; ?>->id = $slug['id'];
<?php endif; ?>
    
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->read(null, $id));
	}

<?php $compact = array(); ?>
    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function <?php echo $admin ?>add() {
		if ($this->request->is('post')) {
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($admin): ?>
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
<?php else: ?>
                $this->Session->setFlash(__d('public', 'Poprawnie zapisano.'));
<?php endif; ?>
                $this->redirect(array('action' => 'index'));
            } else {
<?php if ($admin): ?>
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
<?php else: ?>
                $this->Session->setFlash(__d('public', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
<?php endif; ?>
            }
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}

<?php $compact = array(); ?>
    /**
    * Akcja edytująca obiekt
    *
    * @param string $id
    * @return void
    */
	public function <?php echo $admin; ?>edit($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($admin): ?>
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
<?php else: ?>
                $this->Session->setFlash(__d('public', 'Poprawnie zapisano.'));
<?php endif; ?>
                $this->redirect(array('action' => 'index'));
			} else {
<?php if ($admin): ?>
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
<?php else: ?>
                $this->Session->setFlash(__d('public', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
<?php endif; ?>
			}
		} else {
<?php if ($admin): ?>
            $this-><?php echo $currentModelName; ?>->locale = Configure::read('Config.languages');
			$this->request->data = $this-><?php echo $currentModelName; ?>->read(null, $id);
<?php else: ?>
			$this->request->data = $this-><?php echo $currentModelName; ?>->read(null, $id);
<?php endif; ?>
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
	}

<?php if ($admin): ?>
    /**
    * Akcja usuwająca obiekt
    *
    * @param string $id
    * @return void
    */
	public function <?php echo $admin; ?>delete($id = null, $all = null) {
        $this->FebI18n->delete($id, $all);
        $this->redirect(array('action' => 'index'), null, true);
    }
<?php else: ?>
    /**
    * Akcja usuwająca obiekt
    *
    * @param string $id
    * @return void
    */
	public function <?php echo $admin; ?>delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this-><?php echo $currentModelName; ?>->delete()) {
			$this->Session->setFlash(__d('public', 'Poprawnie usunięto.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__d('public', 'Nie można usunąć.'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
<?php endif; ?>
    