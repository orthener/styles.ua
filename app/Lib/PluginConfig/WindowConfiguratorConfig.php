<?php
/**
 * @author Arkadiusz Dziki
 * 
 * @copyright (c) 2012, feb.net.pl, Arkadiusz Dziki
 */
class WindowConfiguratorConfig {

    private static $instance;

    private function __construct() {

    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new WindowConfiguratorConfig();
        }
        return self::$instance;
    }

    public function invalidWidth(Model $model, $conditions) {
//        $model->WindowLine->WindowsSize->minWidth($conditions);
        return $this->invalidWidthSapor($model, $conditions);
    }
    
    public function invalidHeight(Model $model, $conditions) {
//        $model->WindowLine->WindowsSize->minWidth($conditions);
        return $this->invalidHeightSapor($model, $conditions);
    }
    
    public function invalidWidthByHeight(Model $model, $conditions, $height) {
        return $this->invalidWidthByHeightSapor($model, $conditions, $height);
    }
    
    public function invalidHeightByWidth(Model $model, $conditions, $height) {
        return $this->invalidHeightByWidthSapor($model, $conditions, $height);
    }
    
    public function clearancesLogic(Model $model, $windowConfiguration){
        return $this->clearancesLogicSapor($model, $windowConfiguration);
    }

    protected function invalidWidthByHeightSapor(Model $model, $conditions, $height) {
        $maxWidth = $model->SashesLayout->SashesLayoutsVariant->getMaxWidth($model, $conditions, $height);
        $minWidth = $model->SashesLayout->SashesLayoutsVariant->getMinWidth($model, $conditions, $height);
        
        if(empty($maxWidth) OR empty($minWidth)){
            return $this->invalidWidth($model, $conditions);
        }
        
        $model->validate['width']['range']['rule'][1] = $minWidth-1;
        $model->validate['width']['range']['rule'][2] = $maxWidth+1;
        
        $width_message = __d('public', "Przy wysokości %smm szerokość okna musi mieścić się w zakresie %smm - %smm");
        
        $model->validate['width']['range']['message'] = sprintf(
            $width_message, 
            $height,
            $model->validate['width']['range']['rule'][1]+1,
            $model->validate['width']['range']['rule'][2]-1
        );
    }
    
    protected function invalidHeightByWidthSapor(Model $model, $conditions, $width) {
        $maxHeight = $model->SashesLayout->SashesLayoutsVariant->getMaxHeight($model, $conditions, $width);
        $minHeight = $model->SashesLayout->SashesLayoutsVariant->getMinHeight($model, $conditions, $width);
        
        if(empty($maxHeight) OR empty($minHeight)){
            return $this->invalidHeight($model, $conditions);
        }
        
        if($model->data[$model->alias]['roller_shutter']){
            $maxHeight = min(array($maxHeight, $this->maxHeightRollerShutter($model)));
        }
        
        $model->validate['height']['range']['rule'][1] = $minHeight-1;
        $model->validate['height']['range']['rule'][2] = $maxHeight+1;
        
        $height_message = __d('public', "Przy szerokości %smm wysokość okna musi mieścić się w zakresie %smm - %smm");
        if($model->data[$model->alias]['roller_shutter']){
            $height_message = __d('public', "Przy szerokości %smm wysokość okna z roletą musi mieścić się w zakresie %smm - %smm");
        }
        
        $model->validate['height']['range']['message'] = sprintf(
            $height_message, 
            $width,
            $model->validate['height']['range']['rule'][1]+1,
            $model->validate['height']['range']['rule'][2]-1
        );
    }
    
    protected function invalidWidthByHeightBauelemente(Model $model, $conditions, $height) {
        $minWidth = array();
        $maxWidth = array();

        //horizontal layout:
        $conditions['sashes_layout_id'] = 1;
        $minWidth[] = $model->WindowLine->WindowsSize->minWidth($conditions, $height);
        $maxWidth[] = $model->WindowLine->WindowsSize->maxWidth($conditions, $height)*$model->maxSashes;
        //vertical layout:
        $conditions['sashes_layout_id'] = 2;
        $minWidth[] = $model->WindowLine->WindowsSize->minWidth($conditions, $height/$model->maxSashesVertical);
        $maxWidth[] = $model->WindowLine->WindowsSize->maxWidth($conditions, $height);

        //psk layout:
        $conditions['sashes_layout_id'] = 3;
        $minWidth[] = $model->WindowLine->WindowsSize->minWidth($conditions, $height);
        $maxWidth[] = $model->WindowLine->WindowsSize->maxWidth($conditions, $height);

        for($i = 0; $i < 3; $i++){
            if(empty($minWidth[$i])){
                unSet($minWidth[$i]);
            }
            if(empty($maxWidth[$i])){
                unSet($maxWidth[$i]);
            }
        }

        if(empty($minWidth) || empty($maxWidth)){
            $model->invalidWidth();
//                throw new InternalErrorException("Invalid prices table.");
        } else {

            $minWidth = min($minWidth);
            $maxWidth = max($maxWidth);
            $maxWidth = min(array($maxWidth+1, $model->validate['width']['range']['rule'][2]));

            $model->validate['width']['range']['rule'][1] = $minWidth-1;
            $model->validate['width']['range']['rule'][2] = $maxWidth+1;
            if($model->data[$model->alias]['sizeof'] == 'hole'){
                $test = $model->data;
                $test[$model->alias]['sizeof'] = 'window';
                $test[$model->alias]['width'] = $model->validate['width']['range']['rule'][1];
                $test[$model->alias]['height'] = $model->validate['height']['range']['rule'][1];
                $test = $config->clearancesLogic($model, $test);
                $model->validate['width']['range']['rule'][1] = $test[$model->alias]['hole_width'];

                $test[$model->alias]['width'] = $model->validate['width']['range']['rule'][2];
                $test[$model->alias]['height'] = $model->validate['height']['range']['rule'][2];
                $test = $config->clearancesLogic($model, $test);
                $model->validate['width']['range']['rule'][2] = $test[$model->alias]['hole_width'];
            }

            if($model->data[$model->alias]['sizeof'] == 'hole'){
                $width_message = __d('public', "Przy wysokości %s szerokość otworu musi mieścić się w zakresie %smm - %smm");
            } else {
                $width_message = __d('public', "Przy wysokości %s szerokość okna musi mieścić się w zakresie %smm - %smm");
            }
            $model->validate['width']['range']['message'] = sprintf(
                    $width_message, 
                    $model->data[$model->alias]['height'],
                    $model->validate['width']['range']['rule'][1]+1,
                    $model->validate['width']['range']['rule'][2]-1
                );
        }
    }
    
    protected function invalidHeightByWidthBauelemente(Model $model, $conditions, $width) {
            
        $minHeight = array();
        $maxHeight = array();

        //horizontal layout:
        $conditions['sashes_layout_id'] = 1;
        $minHeight[] = $model->WindowLine->WindowsSize->minHeight($conditions, $width/$model->maxSashes);
        $maxHeight[] = $model->WindowLine->WindowsSize->maxHeight($conditions, $width, $model->maxSashes);
        //vertical layout:
        $conditions['sashes_layout_id'] = 2;
        $minHeight[] = $model->WindowLine->WindowsSize->minHeight($conditions, $width);
        $maxHeight[] = $model->WindowLine->WindowsSize->maxHeight($conditions, $width) * $model->maxSashesVertical;

        //psk layout:
        $conditions['sashes_layout_id'] = 3;
        $minHeight[] = $model->WindowLine->WindowsSize->minHeight($conditions, $width);
        $maxHeight[] = $model->WindowLine->WindowsSize->maxHeight($conditions, $width);

        for($i = 0; $i < 3; $i++){
            if(empty($minHeight[$i])){
                unSet($minHeight[$i]);
            }
            if(empty($maxHeight[$i])){
                unSet($maxHeight[$i]);
            }
        }

        if(empty($minHeight) || empty($maxHeight)){
            $config->invalidHeight($model, $conditions);
        } else {
            $minHeight = min($minHeight);
            $maxHeight = max($maxHeight);
            $maxHeight = min(array($maxHeight+1, $model->validate['height']['range']['rule'][2]));

            $model->validate['height']['range']['rule'][1] = $minHeight-1;
            $model->validate['height']['range']['rule'][2] = $maxHeight+1;
            if($model->data[$model->alias]['sizeof'] == 'hole'){
                $test = $model->data;
                $test[$model->alias]['sizeof'] = 'window';
                $test[$model->alias]['width'] = $model->validate['width']['range']['rule'][1];
                $test[$model->alias]['height'] = $model->validate['height']['range']['rule'][1];
                $test = $config->clearancesLogic($model, $test);
                $model->validate['height']['range']['rule'][1] = $test[$model->alias]['hole_height'];

                $test[$model->alias]['width'] = $model->validate['width']['range']['rule'][2];
                $test[$model->alias]['height'] = $model->validate['height']['range']['rule'][2];
                $test = $config->clearancesLogic($model, $test);
                $model->validate['height']['range']['rule'][2] = $test[$model->alias]['hole_height'];
            }

            if($model->data[$model->alias]['sizeof'] == 'hole'){
                $height_message = __d('public', "Przy szerokości %s wysokość otworu musi mieścić się w zakresie %smm - %smm");
            } else {
                $height_message = __d('public', "Przy szerokości %s wysokość okna musi mieścić się w zakresie %smm - %smm");
            }
            $model->validate['height']['range']['message'] = sprintf(
                    $height_message, 
                    $model->data[$model->alias]['width'],
                    $model->validate['height']['range']['rule'][1]+1,
                    $model->validate['height']['range']['rule'][2]-1
                );
        }
    }
    
    protected function invalidWidthSapor(Model $model, $conditions){
        
        $maxWidth = $model->SashesLayout->SashesLayoutsVariant->getMaxWidth($model, $conditions);
        $minWidth = $model->SashesLayout->SashesLayoutsVariant->getMinWidth($model, $conditions);
        if(!empty($minWidth)){
            $model->validate['width']['range']['rule'][1] = $minWidth-1;
        }
        if(!empty($maxWidth)){
            $model->validate['width']['range']['rule'][2] = $maxWidth+1;
        }
        
        if(empty($maxWidth) OR empty($minWidth)){
			$model->validate['width']['invalid'] = array(
				'rule' => array('uuid'),
				'message' => __d('public', 'W tym momencie nie jest możliwe skonfigurowanie okna w wybranej linii okien'),
			);
        } else {
            unSet($model->validate['width']['invalid']);
            $message = __d('public', "Szerokość okna musi mieścić się w zakresie %smm - %smm");
            $model->validate['width']['range']['message'] = sprintf(
                $message, 
                $model->validate['width']['range']['rule'][1]+1,
                $model->validate['width']['range']['rule'][2]-1
            );
        }
    }
    
    protected function invalidHeightSapor(Model $model, $conditions){
        
        $maxHeight = $model->SashesLayout->SashesLayoutsVariant->getMaxHeight($model, $conditions);
        $minHeight = $model->SashesLayout->SashesLayoutsVariant->getMinHeight($model, $conditions);
        if(!empty($minHeight)){
            $model->validate['height']['range']['rule'][1] = $minHeight-1;
        }
        if(!empty($maxHeight)){
            $model->validate['height']['range']['rule'][2] = $maxHeight+1;
        }
        
        
        if(empty($maxHeight) OR empty($minHeight)){
			$model->validate['height']['invalid'] = array(
				'rule' => array('uuid'),
				'message' => __d('public', 'W tym momencie nie jest możliwe skonfigurowanie okna w wybranej linii okien'),
			);
        } else {
            unSet($model->validate['height']['invalid']);
            $height_message = __d('public', "Wysokość okna musi mieścić się w zakresie %smm - %smm");
            $model->validate['height']['range']['message'] = sprintf(
                $height_message, 
                $model->validate['height']['range']['rule'][1]+1,
                $model->validate['height']['range']['rule'][2]-1
            );
            
            if($model->data[$model->alias]['roller_shutter']){
                $maxHeightRollerShutter = $this->maxHeightRollerShutter($model);

                if($maxHeightRollerShutter < ($model->validate['height']['range']['rule'][2]-1)){
                    $model->validate['height']['range']['rule'][2] = $maxHeightRollerShutter+1;
                    $height_message = __d('public', "Wysokość okna z roletą musi mieścić się w zakresie %smm - %smm");
                    $model->validate['height']['range']['message'] = sprintf(
                        $height_message, 
                        $model->validate['height']['range']['rule'][1]+1,
                        $model->validate['height']['range']['rule'][2]-1
                    );
                }
            }
            
        }
    }
    
    protected function maxHeightRollerShutter(Model $model){
        $maxHeightRollerShutter = $model->RollerShutterBoxColor->RollerShutterColorGroup->RollerShutterBoxSize->find('first', array(
            'recursive' => -1,
            'order' => 'RollerShutterBoxSize.max_height_mm DESC',
        ));
        return $maxHeightRollerShutter['RollerShutterBoxSize']['max_height_mm'] - $maxHeightRollerShutter['RollerShutterBoxSize']['height_a'];
    }
    
    protected function invalidWidthBauelemente(Model $model, $conditions){
        $minWidth = $model->WindowLine->WindowsSize->minWidth($conditions, null);
        if(!empty($minWidth)){
            $model->validate['width']['range']['rule'][1] = $minWidth-1;
        }
        $maxWidth = $model->WindowLine->WindowsSize->maxWidth($conditions, null) * $model->maxSashes;
        if(!empty($maxWidth)){
            $model->validate['width']['range']['rule'][2] = min(array($maxWidth+1,$model->validate['width']['range']['rule'][2]));
        }
        
        if($model->data[$model->alias]['sizeof'] == 'hole'){
            $test = $model->data;
            $test[$model->alias]['sizeof'] = 'window';
            $test[$model->alias]['width'] = $model->validate['width']['range']['rule'][1];
            $test[$model->alias]['height'] = $model->validate['height']['range']['rule'][1];
            $test = $model->clearancesLogic($test);
            $model->validate['width']['range']['rule'][1] = $test[$model->alias]['hole_width'];

            $test[$model->alias]['width'] = $model->validate['width']['range']['rule'][2];
            $test[$model->alias]['height'] = $model->validate['height']['range']['rule'][2];
            $test = $model->clearancesLogic($test);
            $model->validate['width']['range']['rule'][2] = $test[$model->alias]['hole_width'];
        }
        
        if($model->data[$model->alias]['sizeof'] == 'hole'){
            $width_message = __d('public', "Szerokość otworu musi mieścić się w zakresie %smm - %smm");
        } else {
            $width_message = __d('public', "Szerokość okna musi mieścić się w zakresie %smm - %smm");
        }
        $model->validate['width']['range']['message'] = sprintf(
                $width_message,
                $model->validate['width']['range']['rule'][1]+1,
                $model->validate['width']['range']['rule'][2]-1
            );
    }
    
    protected function invalidHeightBauelemente(Model $model, $conditions){
        $minHeight = $model->WindowLine->WindowsSize->minHeight($conditions, null);
        if(!empty($minHeight)){
            $model->validate['height']['range']['rule'][1] = $minHeight-1;
        }
        $maxHeight = $model->WindowLine->WindowsSize->maxHeight($conditions, null) * $model->maxSashesVertical;
        if(!empty($maxHeight)){
            $model->validate['height']['range']['rule'][2] = min(array($maxHeight+1, $model->validate['height']['range']['rule'][2]));
        }
                
        if($model->data[$model->alias]['sizeof'] == 'hole'){
            $test = $model->data;
            $test[$model->alias]['sizeof'] = 'window';
            $test[$model->alias]['width'] = $model->validate['width']['range']['rule'][1];
            $test[$model->alias]['height'] = $model->validate['height']['range']['rule'][1];
            $test = $config->clearancesLogic($model, $test);
            $model->validate['height']['range']['rule'][1] = $test[$model->alias]['hole_height'];

            $test[$model->alias]['width'] = $model->validate['width']['range']['rule'][2];
            $test[$model->alias]['height'] = $model->validate['height']['range']['rule'][2];
            $test = $config->clearancesLogic($model, $test);
            $model->validate['height']['range']['rule'][2] = $test[$model->alias]['hole_height'];
        }
        
        if($model->data[$model->alias]['sizeof'] == 'hole'){
            $height_message = __d('public', "Wysokość otworu musi mieścić się w zakresie %smm - %smm");
        } else {
            $height_message = __d('public', "Wysokość okna musi mieścić się w zakresie %smm - %smm");
        }
        $model->validate['height']['range']['message'] = sprintf(
                $height_message, 
                $model->validate['height']['range']['rule'][1]+1,
                $model->validate['height']['range']['rule'][2]-1
            );
    }
    
    protected function clearancesLogicSapor(Model $model, $windowConfiguration){
        if(empty($windowConfiguration['WindowConfiguration']['window_line_id'])){
            return $windowConfiguration;
        }
        $width_clearance = 15;
        $height_clearance = 15;

        $windowConfiguration['WindowConfiguration']['real_width'] = 
            $windowConfiguration['WindowConfiguration']['width'];
        $windowConfiguration['WindowConfiguration']['hole_width'] = 
            $windowConfiguration['WindowConfiguration']['width'] + 2*$width_clearance;
        $windowConfiguration['WindowConfiguration']['real_height'] = 
            $windowConfiguration['WindowConfiguration']['height'];
        $windowConfiguration['WindowConfiguration']['hole_height'] = 
            $windowConfiguration['WindowConfiguration']['height'] + 2 * $height_clearance + $model->sillProfile;
        
        return $windowConfiguration;
    }
    
    protected function clearancesLogicBauelemente(Model $model, $windowConfiguration){
        if(empty($windowConfiguration['WindowLine'])){
            return $windowConfiguration;
        }
        $width_clearance = $model->WindowLine->WindowClearance->findClearance(
                $windowConfiguration['WindowLine']['window_clearance_group_id'], 
                empty($windowConfiguration['WindowConfiguration']['color_place'])?0:1, 
                $windowConfiguration['WindowConfiguration']['width']
        );
        $height_clearance = $model->WindowLine->WindowClearance->findClearance(
                $windowConfiguration['WindowLine']['window_clearance_group_id'], 
                empty($windowConfiguration['WindowConfiguration']['color_place'])?0:1, 
                $windowConfiguration['WindowConfiguration']['height']
        );

        
        if($windowConfiguration['WindowConfiguration']['sizeof'] == 'window'){
            $windowConfiguration['WindowConfiguration']['real_width'] = 
                $windowConfiguration['WindowConfiguration']['width'];
            $windowConfiguration['WindowConfiguration']['hole_width'] = 
                $windowConfiguration['WindowConfiguration']['width'] + 2*$width_clearance;
            $windowConfiguration['WindowConfiguration']['real_height'] = 
                $windowConfiguration['WindowConfiguration']['height'];
            $windowConfiguration['WindowConfiguration']['hole_height'] = 
                $windowConfiguration['WindowConfiguration']['height'] + 2*$height_clearance+$model->sillProfile;
        } else {
            $windowConfiguration['WindowConfiguration']['real_width'] = 
                $windowConfiguration['WindowConfiguration']['width'] - 2*$width_clearance;
            $windowConfiguration['WindowConfiguration']['hole_width'] = 
                $windowConfiguration['WindowConfiguration']['width'];
            $windowConfiguration['WindowConfiguration']['real_height'] = 
                $windowConfiguration['WindowConfiguration']['height'] - (2*$height_clearance+$model->sillProfile);
            $windowConfiguration['WindowConfiguration']['hole_height'] = 
                $windowConfiguration['WindowConfiguration']['height'];
            
//            if($windowConfiguration['WindowConfiguration']['window_line_id'] == 1){
//                //DREWNO:
//                $luzy = array(10,10,10,10);
//            } elseif($windowConfiguration['WindowConfiguration']['window_line_id'] == 2){
//                //alu:
//                $luzy = array(10,10,15,20);
//                if(!empty($windowConfiguration['WindowConfiguration']['color_place'])){
//                    //ALU KOLOR:
//                    $luzy = array(10,15,20,20);
//                }
//            } else {
//                //PVC:
//                $luzy = array(10,15,20,25);
//                if(!empty($windowConfiguration['WindowConfiguration']['color_place'])){
//                    //PVC kolor:
//                    $luzy = array(15,20,25,30);
//                }
//            }
//            $windowConfiguration['WindowConfiguration']['real_width'] = $windowConfiguration['WindowConfiguration']['width'];
//            $windowConfiguration['WindowConfiguration']['real_height'] = $windowConfiguration['WindowConfiguration']['height'];
        }        
        return $windowConfiguration;
    }

}
?>
