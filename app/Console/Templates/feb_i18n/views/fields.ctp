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
<fieldset>
    <legend><?php echo "<?php echo __d('cms', '".$singularHumanName." Data'); ?>" ?></legend>
    <?php
    echo "<?php\n";
    foreach ($fields as $field) {
        if ($field == $primaryKey) {
            continue;
        } elseif (!in_array($field, array('created', 'modified', 'updated', 'slug'))) {
            if (in_array($field, array('img', 'file', 'image'))) {
                echo "\t\techo \$this->FebForm->file('{$field}', array('type' => 'file', 'label' => __d('cms', '".Inflector::humanize($field)."')));\n";
            } else {
                echo "\t\techo \$this->Form->input('{$field}', array('label' => __d('cms', '".Inflector::humanize($field)."')));\n";
            }
        }
    }
    if (!empty($associations['hasAndBelongsToMany'])) {
        foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
            echo "\t\techo \$this->Form->input('{$assocName}', 'label' => __d('cms', '{$assocName}'));\n";
        }
    }
    echo "\t?>\n";
    ?>
</fieldset>
