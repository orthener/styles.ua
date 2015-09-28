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
<?php echo "<?php \$this->set('title_for_layout', __d('cms', 'List').' &bull; '.__d('cms', '{$pluralHumanName}')); ?>"; ?>
<div class="<?php echo $pluralVar;?> index">
    <?php $controllerName = Inflector::pluralize($modelClass); ?> 
    <?php echo "<?php echo \$this->Element('{$controllerName}/table_index'); ?> \n"?>
    <?php echo "<?php echo \$this->Element('cms/paginator'); ?>"?>
</div>

<div class="actions">
	<h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
	<ul>
		<?php echo "<?php echo \$this->Permissions->link(__d('cms', 'New " . $singularHumanName . "'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>\n";?>
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
