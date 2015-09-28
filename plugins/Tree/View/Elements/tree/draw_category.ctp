<?php if ($data): 
//$groups = array('investors', 'residents', 'tourists');
$group = '';
$echo = '';
if($this->Session->check('group')){
    $group = $this->Session->read('group');
}
?>
    <ul>
    <?php foreach ($data as $key=>$category): ?>
<?php 
    $list = '';
    $display = true;
    if(!empty($category['Category']['model']) AND !empty($category['Category']['row_id'])){
        if(!empty($group) AND $category[$category['Category']['model']][$group] == 0){
            $display = false;
        }
    } else {
        if(!empty($group) AND $category['Category'][$group] == 0){
            $display = false;
        }
    }


    if(!empty($category['Category']['model']) AND !empty($category['Category']['row_id'])){
        $controller = Inflector::pluralize(strtolower($category['Category']['model']));
        $list = $this->Html->link($category['Category']['name'], array('plugin' => false, 'admin' => false, 'controller' => $controller, 'action' => 'view', $category[$category['Category']['model']]['slug']), array('title' => $category[$category['Category']['model']]['name']));
    } elseif(!empty($category['Category']['url'])){
        $list = $this->Html->link($category['Category']['name'], $category['Category']['url'], array('title' => $category['Category']['url']));
    } elseif(!empty($category['children'])) {
        $list = $this->Html->link($category['Category']['name'], '#', array('onclick' => 'return false;'));
    }
?>
<?php if($list AND $display) { ?>
    <?php $echo .= '<li>'.$list; ?>
            <?php $echo .= $this->element('tree/draw_category', array('data' => $category['children'])); ?>
    <?php $echo .= '</li>'; ?>
<?php } ?>    
    <?php endforeach; ?>
    </ul>
<?php 
    if(!empty($echo)){
        echo '<ul>
        '.$echo.'
        </ul>';
    }
?>
<?php endif; ?>
