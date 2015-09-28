<?php
/**
 * Model template file.
 *
 * Used by bake to create new Model files.
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
 * @package       Cake.Console.Templates.default.classes
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

echo "<?php\n";
echo "App::uses('{$plugin}AppModel', '{$pluginPath}Model');\n";
?>
/**
 * <?php echo $name ?> Model
 *
<?php
foreach (array('hasOne', 'belongsTo', 'hasMany', 'hasAndBelongsToMany') as $assocType) {
	if (!empty($associations[$assocType])) {
		foreach ($associations[$assocType] as $relation) {
			echo " * @property {$relation['className']} \${$relation['alias']}\n";
		}
	}
}
?>
 */
class <?php echo $name ?> extends <?php echo $plugin; ?>AppModel {

<?php 
    $addUpload = '';
    $addUSlug = '';
    if (isset($fields['img']) || isset($fields['image']) || isset($fields['file'])) {
        $addUpload = "'Image.Upload',";
    }    
    if (isset($fields['slug'])) {
        $addUSlug = "'Slug.Slug',";
    }
?>
    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array(<?php echo $addUpload.$addUSlug ?>);
    
<?php if ($useDbConfig != 'default'): ?>
    /**
    * Konfiguracja bazy
    *
    * @var string
    */
	public $useDbConfig = '<?php echo $useDbConfig; ?>';
<?php endif;?>
<?php if ($useTable && $useTable !== Inflector::tableize($name)):
	$table = "'$useTable'";
	echo "\t/**\n \t* Use table\n \t*\n \t* @var mixed False or table name\n \t*/\n";
	echo "\tpublic \$useTable = $table;\n";
endif;
if ($primaryKey !== 'id'): ?>
    /**
    * Primary key
    *
    * @var string
    */
	public $primaryKey = '<?php echo $primaryKey; ?>';
<?php endif;
if ($displayField): ?>
    /**
    * Display field
    *
    * @var string
    */
	public $displayField = '<?php echo $displayField; ?>';
<?php endif;
if (isSet($fields['created'])): ?>
    /**
    * Domyślne sortowanie
    *
    * @var string
    */
	public $order = '<?php echo $name; ?>.created DESC';
<?php endif;
foreach ($associations as $assoc):
	if (!empty($assoc)):
		break;
	endif;
endforeach;

foreach (array('hasOne', 'belongsTo') as $assocType):
	if (!empty($associations[$assocType])):
		$typeCount = count($associations[$assocType]);
		echo "\n\t/**\n \t* $assocType associations\n \t*\n \t* @var array\n \t*/";
		echo "\n\tpublic \$$assocType = array(";
		foreach ($associations[$assocType] as $i => $relation):
			$out = "\n\t\t'{$relation['alias']}' => array(\n";
			$out .= "\t\t\t'className' => '{$relation['className']}',\n";
			$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
			$out .= "\t\t\t'conditions' => '',\n";
			$out .= "\t\t\t'fields' => '',\n";
			$out .= "\t\t\t'order' => ''\n";
			$out .= "\t\t)";
			if ($i + 1 < $typeCount) {
				$out .= ",";
			}
			echo $out;
		endforeach;
		echo "\n\t);\n";
	endif;
endforeach;

if (!empty($associations['hasMany'])):
	$belongsToCount = count($associations['hasMany']);
	echo "\n\t/**\n \t* hasMany associations\n \t*\n \t* @var array\n \t*/";
	echo "\n\tpublic \$hasMany = array(";
	foreach ($associations['hasMany'] as $i => $relation):
		$out = "\n\t\t'{$relation['alias']}' => array(\n";
		$out .= "\t\t\t'className' => '{$relation['className']}',\n";
		$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
		$out .= "\t\t\t'dependent' => false,\n";
		$out .= "\t\t\t'conditions' => '',\n";
		$out .= "\t\t\t'fields' => '',\n";
		$out .= "\t\t\t'order' => '',\n";
		$out .= "\t\t\t'limit' => '',\n";
		$out .= "\t\t\t'offset' => '',\n";
		$out .= "\t\t\t'exclusive' => '',\n";
		$out .= "\t\t\t'finderQuery' => '',\n";
		$out .= "\t\t\t'counterQuery' => ''\n";
		$out .= "\t\t)";
		if ($i + 1 < $belongsToCount) {
			$out .= ",";
		}
		echo $out;
	endforeach;
	echo "\n\t);\n\n";
endif;

if (!empty($associations['hasAndBelongsToMany'])):
	$habtmCount = count($associations['hasAndBelongsToMany']);
	echo "\n\t/**\n \t* hasAndBelongsToMany associations\n \t*\n \t* @var array\n \t*/";
	echo "\n\tpublic \$hasAndBelongsToMany = array(";
	foreach ($associations['hasAndBelongsToMany'] as $i => $relation):
		$out = "\n\t\t'{$relation['alias']}' => array(\n";
		$out .= "\t\t\t'className' => '{$relation['className']}',\n";
		$out .= "\t\t\t'joinTable' => '{$relation['joinTable']}',\n";
		$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
		$out .= "\t\t\t'associationForeignKey' => '{$relation['associationForeignKey']}',\n";
		$out .= "\t\t\t'unique' => true,\n";
		$out .= "\t\t\t'conditions' => '',\n";
		$out .= "\t\t\t'fields' => '',\n";
		$out .= "\t\t\t'order' => '',\n";
		$out .= "\t\t\t'limit' => '',\n";
		$out .= "\t\t\t'offset' => '',\n";
		$out .= "\t\t\t'finderQuery' => '',\n";
		$out .= "\t\t\t'deleteQuery' => '',\n";
		$out .= "\t\t\t'insertQuery' => ''\n";
		$out .= "\t\t)";
		if ($i + 1 < $habtmCount) {
			$out .= ",";
		}
		echo $out;
	endforeach;
	echo "\n\t);\n\n";
endif;
?>
    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
<?php 
if (!empty($validate)):
	echo "\t\t\$this->validate = array(\n";
	foreach ($validate as $field => $validations):
		echo "\t\t\t'$field' => array(\n";
		foreach ($validations as $key => $validator):
            if (in_array($field, array('img', 'image', 'file'))) {
                echo "\t\t\t\t'mime' => array(\n";
                echo "\t\t\t\t\t'rule'=>array('validateMime','image'),\n";
                echo "\t\t\t\t\t'message' => 'Ten formularz akceptuje jedynie pliki graficzne (jpeg, gif, png)',\n";            
                echo "\t\t\t\t),\n";
                echo "\t\t\t\t'upload' => array(\n";
                echo "\t\t\t\t\t'rule'=>array('validateUpload'),\n";      
                echo "\t\t\t\t),\n";
                continue;
            }
			echo "\t\t\t\t'$key' => array(\n";
			echo "\t\t\t\t\t'rule' => array('$validator'),\n";
			echo "\t\t\t\t\t'message' => __d('cms', 'Pole formularza nie może być puste'),\n";            
			echo "\t\t\t\t\t//'allowEmpty' => false,\n";
			echo "\t\t\t\t\t//'required' => false,\n";
			echo "\t\t\t\t\t//'last' => false, // Stop validation after this rule\n";
			echo "\t\t\t\t\t//'on' => 'create', // Limit validation to 'create' or 'update' operations\n";
			echo "\t\t\t\t),\n";
		endforeach;
		echo "\t\t\t),\n";
	endforeach;
	echo "\t\t);\n";
endif;
?>
    }
    
    /**
     * Konstruktor klasy modelu
     * 
     * @param int $id
     * @param array $table
     * @param bool $ds 
     */
    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //$this->virtualFields = array('fullname' => "CONCAT({$this->alias}.field_1, ' ', {$this->alias}.field_2)");
    }
    
    /**
     * Logika dla globalnej wyszukiwarki w cms
     * nadpisuje metodę z AppModel
     * 
     * @param array $options
     * @param array $params
     * @return type array
     */
//    public function search($options, $params = array()) {
//        $fraz = $options['Searcher']['fraz'];
//        $params['conditions']['OR']["<?php echo $name ?>.<?php echo $displayField ?> LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

