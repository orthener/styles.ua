<?php
/**
 * FebTree behavior class.
 *
 * Extends Tree behaviour from Cake-core.
 *
 * PHP versions 4 and 5
 *
 * @copyright     FEB
 * @link          http://feb.net.pl FEB
 * @package       feb
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * FebTree Behavior.
 *
 * Enables a model object to act as a node-based tree.
 *
 * @see http://book.cakephp.org/view/1339/Tree
 * @package       feb
 */
 
 App::Import('Behavior', 'Tree');
 
class FebTreeBehavior extends TreeBehavior {


// /**
//  * Defaults
//  *
//  * @var array
//  * @access protected
//  */
// 	var $_defaults = array(
// 		'parent' => 'parent_id', 'left' => 'lft', 'right' => 'rght',
// 		'scope' => '1 = 1', 'type' => 'nested', '__parentChange' => false, 'recursive' => -1
// 	);

    function findTree(&$model, $conditions = array()){
        $findTree = $model->find('threaded', array(
            'conditions'=>$conditions,
            'order'=>"{$model->alias}.{$this->settings[$model->alias]['left']} ASC, {$model->alias}.{$this->settings[$model->alias]['parent']} ASC"
        ));
        return $findTree;
    }


    function validateDepth(&$model, $id, $destination_id = null, $mode = null){

        if(empty($model->validate['depth']['rule']['maxdepth'])){
            return true;
        }
    
        //fields names:        
        $lft = $this->settings[$model->alias]['left'];
        $rght = $this->settings[$model->alias]['right'];
        $parent = $this->settings[$model->alias]['parent'];
        
        $model->recursive = -1;

        //get node to move
        $node = $model->find('first', array('conditions' => array("{$model->alias}.{$model->primaryKey} = {$id}")));
        
        //get destination node
        $destination_node = $model->find('first', array('conditions' => array("{$model->alias}.{$model->primaryKey} = {$destination_id}")));
        
        //both: node and destination must exists 
        if(empty($node) OR empty($destination_node)){
            return null;
        }

        if($mode){
            if($destination_node[$model->alias][$parent]){
                $parent_node = $model->find('first', array('conditions' => array("{$model->alias}.{$model->primaryKey} = {$destination_node[$model->alias][$parent]}")));
            }
        } else {
            $parent_node = $destination_node;
        }

        if(!empty($parent_node)){
            //new parent can not be "inside" node subtree (and can't by $node itself).
            if($parent_node[$model->alias][$lft] >= $node[$model->alias][$lft] AND 
                $parent_node[$model->alias][$rght] <= $node[$model->alias][$rght]){
                return null;
            }
        }
        
        if(empty($parent_node)){
            return true;
        }

        /////////////////////////////
        //new parent depth:
        /////////////////////////////
        
        //$path = $model->getpath($parent_node[$model->alias][$model->primaryKey], array($model->primaryKey));
        //$depth = count($path);

        $threaded = $model->find('threaded', array(
            'recursive'=> -1,
            'fields' => array($model->primaryKey, $parent, $lft, $rght),
            'order'=> "{$model->alias}.{$lft} ASC", 
            'conditions' => array(
                "{$model->alias}.{$lft} >=" => $node[$model->alias][$lft],
                "{$model->alias}.{$rght}  <=" => $node[$model->alias][$rght],
            )
        ));

        $depth += $this->_countDepth($threaded);
        
        return ($depth <= $model->validate['depth']['rule']['maxdepth'])?true:false;

    }

    function _countDepth($threaded){
    
        if(empty($threaded)){
            return 0;
        }

        $max_depth = 0;
    
        foreach($threaded AS &$value){
            $max_depth = max($max_depth, $this->_countDepth($value['children']));
        }
    
        return $max_depth+1; 
    }


    function moveNode(&$model, $id, $destination_id = null, $mode = null){
        //fields names:        
        $lft = $this->settings[$model->alias]['left'];
        $rght = $this->settings[$model->alias]['right'];
        $parent = $this->settings[$model->alias]['parent'];
        
        $model->recursive = -1;

        //get node to move
        $node = $model->find('first', array('conditions' => array("{$model->alias}.{$model->primaryKey} = {$id}")));
        
        //get destination node
        $destination_node = $model->find('first', array('conditions' => array("{$model->alias}.{$model->primaryKey} = {$destination_id}")));
        
        //both: node and destination must exists 
        if(empty($node) OR empty($destination_node)){
            return false;
        }

        if($mode){
            if($destination_node[$model->alias][$parent]){
                $parent_node = $model->find('first', array('conditions' => array("{$model->alias}.{$model->primaryKey} = {$destination_node[$model->alias][$parent]}")));
            }
        } else {
            $parent_node = $destination_node;
        }

        if(!empty($parent_node)){
            //new parent can not be "inside" node subtree (and can't by $node itself).
            if($parent_node[$model->alias][$lft] >= $node[$model->alias][$lft] AND 
                $parent_node[$model->alias][$rght] <= $node[$model->alias][$rght]){
                return false;
            }
        }


        $model->query("LOCK TABLE {$model->useTable} WRITE;");

        $subtree_size = $node[$model->alias][$rght] - $node[$model->alias][$lft] + 1;

        //set negative lft values for node subtree
        $model->query("UPDATE {$model->useTable} SET {$lft} = -{$lft}, {$rght} = - {$rght} WHERE
            {$lft} >= {$node[$model->alias][$lft]} AND {$rght} <= {$node[$model->alias][$rght]} ;");

        if($mode == 'before' OR $mode == 'top'){
            //put node just before destination node

            $shift = $node[$model->alias][$lft]-$destination_node[$model->alias][$lft];

            if($shift>0){
                //node is after destination

                //move forward all lft, rght values between old and new node location 
                $model->query("UPDATE {$model->useTable} SET {$lft} = {$lft}+{$subtree_size} WHERE
                    {$lft} >= {$destination_node[$model->alias][$lft]} AND {$lft} < {$node[$model->alias][$lft]} ;");
                $model->query("UPDATE {$model->useTable} SET {$rght} = {$rght}+{$subtree_size} WHERE
                    {$rght} > {$destination_node[$model->alias][$lft]} AND {$rght} < {$node[$model->alias][$lft]} ;");

                //move backward all lft and rght values of node and its subtree
                $model->query("UPDATE {$model->useTable} SET {$lft} = -{$lft}-{$shift}, {$rght} = -{$rght}-{$shift} WHERE
                    {$lft} < 0 AND {$rght} < 0;");

            } else {
                //node is before destination:
                $shift = $destination_node[$model->alias][$lft] - 1 - $node[$model->alias][$rght];

                //move backward all lft, rght values between old and new node location 
                $model->query("UPDATE {$model->useTable} SET {$lft} = {$lft}-{$subtree_size} WHERE
                    {$lft} < {$destination_node[$model->alias][$lft]} AND {$lft} > {$node[$model->alias][$rght]} ;");
                $model->query("UPDATE {$model->useTable} SET {$rght} = {$rght}-{$subtree_size} WHERE
                    {$rght} < {$destination_node[$model->alias][$lft]} AND {$rght} > {$node[$model->alias][$rght]} ;");

                //move forward all lft and rght values of node and its subtree
                $model->query("UPDATE {$model->useTable} SET {$lft} = -{$lft}+{$shift}, {$rght} = -{$rght}+{$shift} WHERE
                    {$lft} < 0 AND {$rght} < 0;");

            }
        } elseif($mode == 'after' or $mode == 'down'){
            //put node next after destination node

            $shift = $node[$model->alias][$lft] - ($destination_node[$model->alias][$rght] + 1);

            if($shift>0){
                //node is after destination

                //move forward all lft, rght values between old and new node location 
                $model->query("UPDATE {$model->useTable} SET {$lft} = {$lft}+{$subtree_size} WHERE
                    {$lft} > {$destination_node[$model->alias][$rght]} AND {$lft} < {$node[$model->alias][$lft]} ;");
                $model->query("UPDATE {$model->useTable} SET {$rght} = {$rght}+{$subtree_size} WHERE
                    {$rght} > {$destination_node[$model->alias][$rght]} AND {$rght} < {$node[$model->alias][$lft]} ;");

                //move backward all lft and rght values of node and its subtree
                $model->query("UPDATE {$model->useTable} SET {$lft} = -{$lft}-{$shift}, {$rght} = -{$rght}-{$shift} WHERE
                    {$lft} < 0 AND {$rght} < 0;");

            } else {
                //node is before destination:
                $shift = $destination_node[$model->alias][$rght] - $node[$model->alias][$rght];

                //move backward all lft, rght values between old and new node location 
                $model->query("UPDATE {$model->useTable} SET {$lft} = {$lft}-{$subtree_size} WHERE
                    {$lft} < {$destination_node[$model->alias][$rght]} AND {$lft} > {$node[$model->alias][$rght]} ;");
                $model->query("UPDATE {$model->useTable} SET {$rght} = {$rght}-{$subtree_size} WHERE
                    {$rght} <= {$destination_node[$model->alias][$rght]} AND {$rght} > {$node[$model->alias][$rght]} ;");

                //move forward all lft and rght values of node and its subtree
                $model->query("UPDATE {$model->useTable} SET {$lft} = -{$lft}+{$shift}, {$rght} = -{$rght}+{$shift} WHERE
                    {$lft} < 0 AND {$rght} < 0;");

            }
        } else {
            //put node as last destination node child

            $shift = $node[$model->alias][$lft]-$destination_node[$model->alias][$rght];

            if($shift>0){
                //node is after destination

                //move forward all lft, rght values between old and new node location 
                $model->query("UPDATE {$model->useTable} SET {$lft} = {$lft}+{$subtree_size} WHERE
                    {$lft} > {$destination_node[$model->alias][$rght]} AND {$lft} < {$node[$model->alias][$lft]} ;");
                $model->query("UPDATE {$model->useTable} SET {$rght} = {$rght}+{$subtree_size} WHERE
                    {$rght} >= {$destination_node[$model->alias][$rght]} AND {$rght} < {$node[$model->alias][$lft]} ;");

                //move backward all lft and rght values of node and its subtree
                $model->query("UPDATE {$model->useTable} SET {$lft} = -{$lft}-{$shift}, {$rght} = -{$rght}-{$shift} WHERE
                    {$lft} < 0 AND {$rght} < 0;");

            } else {
                //node is before destination:
                $shift = $destination_node[$model->alias][$rght] - 1 - $node[$model->alias][$rght];

                //move backward all lft, rght values between old and new node location 
                $model->query("UPDATE {$model->useTable} SET {$lft} = {$lft}-{$subtree_size} WHERE
                    {$lft} < {$destination_node[$model->alias][$rght]} AND {$lft} > {$node[$model->alias][$rght]} ;");
                $model->query("UPDATE {$model->useTable} SET {$rght} = {$rght}-{$subtree_size} WHERE
                    {$rght} < {$destination_node[$model->alias][$rght]} AND {$rght} > {$node[$model->alias][$rght]} ;");

                //move forward all lft and rght values of node and its subtree
                $model->query("UPDATE {$model->useTable} SET {$lft} = -{$lft}+{$shift}, {$rght} = -{$rght}+{$shift} WHERE
                    {$lft} < 0 AND {$rght} < 0;");

            }


        }
        
        if(!empty($parent_node)){
            $parent_node = $parent_node[$model->alias][$model->primaryKey];
        } else {
            $parent_node = 'NULL';
        }
        $model->query("UPDATE {$model->useTable} SET {$parent} = {$parent_node} WHERE
            {$model->primaryKey} = {$node[$model->alias][$model->primaryKey]}");

        $model->query("UNLOCK TABLES;");

        return true;
        
    }

}
