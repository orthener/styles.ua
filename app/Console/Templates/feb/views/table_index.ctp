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
	<h2><?php echo "<?php echo __d('cms', '{$pluralHumanName}'); ?>";?></h2>
	<table cellpadding="0" cellspacing="0">
    <thead>
	<tr>
	<?php  foreach ($fields as $field):?>
<?php if($primaryKey == $field){continue;}; ?>
            <?php if (!in_array($field, array('slug', 'modified'))) {
                if ($field == 'created' &&  in_array('created', $fields) && in_array('modified', $fields)) {
                    echo "<th><?php echo \$this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo \$this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>\n";
                } else {
                    echo "<th><?php echo \$this->Paginator->sort('{$field}', __d('cms', '".Inflector::humanize($field)."'));?></th>\n";
                }
            } ?>
	<?php endforeach;?>
		<th class="actions"><?php echo "<?php echo __('Actions');?>";?></th>
	</tr>
    </thead>
     <tbody>
	<?php
	echo "<?php
	\$i = 0;
	foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr data-id=\"<?php echo \${$singularVar}['{$modelClass}']['{$primaryKey}']; ?>\">\n";
		foreach ($fields as $field) {
            if($primaryKey == $field){continue;};
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Permissions->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true && !in_array($field, array('slug', 'created', 'modified'))) {
				echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}
        if (in_array('created', $fields) && in_array('modified', $fields)) {
            echo "\t\t<td><?php echo \$this->FebTime->niceShort(\${$singularVar}['{$modelClass}']['created']); ?>&nbsp;&middot;&nbsp;<?php echo \$this->FebTime->niceShort(\${$singularVar}['{$modelClass}']['modified']); ?></td>\n";
        } elseif (in_array('created', $fields)) {
            echo "\t\t<td><?php echo \$this->FebTime->niceShort(\${$singularVar}['{$modelClass}']['created']); ?>&nbsp;</td>\n";
        }
		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t\t<?php //echo \$this->Permissions->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Permissions->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Permissions->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$displayField}'])); ?>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
     </tbody>
	</table>