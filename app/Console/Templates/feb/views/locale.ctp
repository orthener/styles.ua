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
//Model <?php echo "$pluralHumanName \n\n"; ?>
<?php
    foreach($localeFields as $field) {
echo "msgid \"".Inflector::humanize($field)."\"\n";
echo "msgstr \"".Inflector::humanize($field)."\"\n";
    }
echo "\n";

echo "msgid \"{$pluralHumanName}\"\n";
echo "msgstr \"{$pluralHumanName}\"\n\n";

echo "msgid \"New {$singularHumanName}\"\n";
echo "msgstr \"Dodaj {$singularHumanName}\"\n\n";

echo "msgid \"List {$pluralHumanName}\"\n";
echo "msgstr \"Lista {$pluralHumanName}\"\n\n";

echo "msgid \"Edit {$pluralHumanName}\"\n";
echo "msgstr \"Edycja {$pluralHumanName}\"\n\n";

echo "msgid \"Delete {$pluralHumanName}\"\n";
echo "msgstr \"Usuń {$pluralHumanName}\"\n\n";

echo "msgid \"Admin Add {$singularHumanName}\"\n";
echo "msgstr \"Dodawanie {$singularHumanName}\"\n\n";

echo "msgid \"Admin Edit {$singularHumanName}\"\n";
echo "msgstr \"Edycja {$singularHumanName}\"\n\n";

echo "msgid \"{$singularHumanName} Data\"\n";
echo "msgstr \"Dane {$singularHumanName}\"\n\n";

?>