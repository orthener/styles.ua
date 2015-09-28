<?php
/**
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
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php 
    if (strpos($action, 'add') === false):
        echo "<?php \$this->set('title_for_layout', __d('cms', 'Adding').' &bull; '.__d('cms', '{$pluralHumanName}')); ?>";
    else:
        echo "<?php \$this->set('title_for_layout', __d('cms', 'Editing').' &bull; '.__d('cms', '{$pluralHumanName}')); ?>";
    endif;
?>
<h2><?php echo "<?php echo __d('cms', '".Inflector::humanize($action)." ".$singularHumanName."'); ?>" ?></h2>

<div class="<?php echo $pluralVar; ?> form">
    <?php 
        if (in_array('img', $fields) || in_array('image', $fields) || in_array('file', $fields)) {
            echo "<?php echo \$this->Form->create('{$modelClass}', array('type' => 'file')); ?>\n";
        } else {
            echo "<?php echo \$this->Form->create('{$modelClass}'); ?>\n"; 
        }
        $controllerName = Inflector::pluralize($modelClass);
        if (strpos($action, 'add') === false):
            echo "\t<?php echo \$this->Form->input('{$primaryKey}'); ?>\n";
            echo "\t<?php echo \$this->Element('{$controllerName}/fields'); ?>\n";
        else:
            echo "\t<?php echo \$this->Element('{$controllerName}/fields'); ?>\n";
        endif;
    echo "\t<?php echo \$this->Form->end(__d('cms', 'Submit')); ?>\n";
    ?>
</div>
<div class="actions">
    <h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
    <ul>
        <?php if (strpos($action, 'add') === false): ?>
<?php echo "<?php echo \$this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$displayField}'))); ?> \n"; ?>
        <?php endif; ?>
<?php echo "<?php echo \$this->Permissions->link(__d('cms', 'List " . $pluralHumanName . "'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>\n"; ?>
        <?php
        $done = array();
        foreach ($associations as $type => $data) {
            foreach ($data as $alias => $details) {
                if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                    echo "<?php //echo \$this->Permissions->link(__d('cms', 'List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> \n";
                    echo "\t\t<?php //echo \$this->Permissions->link(__d('cms', 'New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> \n";
                    $done[] = $details['controller'];
                }
            }
        }
        ?>
    </ul>
</div>
