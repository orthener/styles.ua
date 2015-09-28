<?php
/**
 * Jak uzywac:
 * 
 *  <?php echo $febSocial->init(); ?>
 *  <?php echo $febSocial->simpleBtns(array('wykop' => array('title' => $news['News']['title']), 'facebook', 'twitter', 'blip')); ?>
 * 
 *  wykop nie jest ustawiony z automatu na 
 *  http://sharethis.com/
 *  
 */

class FebSocialHelper extends Helper {

    var $helpers = array('Html');     
    /**
     * @autor Slawomir Jach
     * @param type $names Tablica z nazwami uslug ( Jako jedyny ma mozliwosc wykopu )
     */
    function simpleBtns($names) {
        //debug($this->params);
        if (is_array($names) && count($names) > 0) {
            $sthis = '';
            foreach ($names as $key => &$btn) {

                if ($key === 'wykop') {
                    $sthis .= '<span class="stButtonWykop"><a target="_blank" title="Wykop.pl" href="http://www.wykop.pl/dodaj?url='.Router::url($this->params['url'],true).'&amp;title='.$btn['title'].'">'.$this->Html->image('social/wykop.png').'</a></span>';
                } else {
                    $options = array('class' => "st_$btn");
                    $sthis .= $this->Html->tag('span', '', $options); 
                }
            }
            return $sthis;
        } else {
            die('PASSED ARGUMENT TYPE MUST BE AN ARRAY.');
        }
    
    }

    /**
     * Initial call to load the required javascript code on the page.
     * @param string $pubid Publisher Id; Provided in user's account at sharethis.com
     * @param string $wtype Widget Type; It can be either o|c [o]auth | [c]lassic
     * @return string $sthis A string containing the initial call of a javascript.
     */
    function init($pubid=null, $wtype='c') {
        // Generate the javascript code to set Widget Type variable based on a passed argument.
        $wtype = 'o' === $wtype ? 'true' : 'false';
        $sthis = $this->Html->scriptBlock("var switchTo5x=$wtype;");

        // Add javascript that contains publisher id.
        $publink = "stLight.options({publisher:'";
        $publink .= empty($pubid) ? '' : $pubid;
        $publink .= "'});";
        $sthis .= $this->Html->scriptBlock($publink);

        // Add javascript to display share buttons.
        $btnjs = 'http://w.sharethis.com/button/buttons.js';
        $sthis .= $this->Html->script($btnjs);
        return $sthis;
    }

    /**
     * Print out a button based on the argument passed.
     * @param string|array $names A name of single button OR an array of more than one button names e.g. facebook|tweet
     * @param string $pos Position in which all the buttons will be displayed. (h-Horizontal|v-Vertical)
     * @return string A string containing span tag element with appropriate button value.
     */
    function btnWithCount($names, $pos='h') {
        // Display more than one buttons horizontally or vertically based on a value of second argument passed.
        if (is_array($names) && count($names) > 0) {
            $sthis = '';
            foreach ($names as &$btn) {
                $options = array('class' => 'st_' . $btn . '_' . $pos . 'count', 'displayText' => ucfirst($btn));
                $sthis .= $this->Html->tag('span', '', $options);
            }
            return $sthis;
        }
        // Here we check if the passed data is not an array and if user has not used comma to separate the button names
        // then only print the buttons for passed data.
        else if (!is_array($names) && false === strpos($names, ',')) {
            $options = array('class' => 'st_' . $names . '_' . $pos . 'count', 'displayText' => ucfirst($names));
            $sthis = $this->Html->tag('span', '', $options);
            return $sthis;
        }
        else 
            die('INVALID DATA PASSED!');
    }

    /**
     * Print out all the buttons passed into an argument array vector.
     * @param array $names Array containing all the button names to be displayed on the page.
     * @return string A string with the buttons in tray.
     */
    function btnsInTray($names) {
        // Display all the buttons in a single horizontal tray.
        if (is_array($names) && count($names) > 0) {
            $sthis = '';
            foreach ($names as &$btn) {
                $options = array('class' => "st_$btn", 'displayText' => ucfirst($btn));
                $sthis .= $this->Html->tag('span', '', $options);
            }
            return $sthis;
        } else {
            die('PASSED ARGUMENT TYPE MUST BE AN ARRAY.');
        }
    }
    
}
?>