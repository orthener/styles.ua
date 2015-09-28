<div id="registerBox">
    <?php 
     echo $this->Form->create('User');
     echo $this->Form->input('email', array('label' => __d('cms', 'E-mail'), 'readonly' => 'readonly'));
     echo $this->Form->input('name', array('label' => __d('cms', 'Nazwa')));
     echo $this->Form->input('newpassword', array('label' => __d('cms', 'Hasło'), 'type'=>'password'));
     echo $this->Form->input('confirmpassword', array('label' => __d('cms', 'Powtórz hasło'), 'type'=>'password'));

     $rules_link = $this->Html->link(__d('cms', 'Regulaminem'), array('controller' => 'pages', 'action' => 'strona', 'regulamin'));
     $privacy_policy_link = $this->Html->link(__d('cms', 'Polityką prywatności'), array('controller' => 'pages', 'action' => 'strona', 'polityka-prywatnosci'));
     $label = sprintf(__d('cms', 'Oświadczam, że zapoznałem się z %s oraz %s, rozumiem je i zobowiązuje sie je przestrzegać.'), $rules_link, $privacy_policy_link);
     echo $this->Form->input('rules', array( 'type'=>'checkbox', 'label' => $label ));
     
     echo $this->Form->end(__d('cms', 'REJESTRACJA'));
    ?>
</div>
<!--Skrypt do prostej jsowej wlidacji-->
<script type="text/javascript">
//   
//   WERSJA Z REGULAMINEM POP-UP
//   
//    var rulesWindow = function () {
//        window.open('<?php //echo $this->Html->url(array('pop_up_rules')); ?>', 'Regulamin', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=640,height=530').focus(); 
//        return false
//    }
//    var privacyPolicyWindow = function () {
//        window.open('<?php //echo $this->Html->url(array('pop_up_privacy_policy')); ?>', 'Regulamin', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=640,height=530').focus(); 
//        return false
//    }
//    /**
//     * Otwiera Okienko z Regulaminem 
//     */
//    $('#rulesLink').click(competitionRulesWindow);
//    /**
//     * Otwiera Okienko z Regulaminem Forum
//     */
//    $('#forumRulesLink').click(competitionRulesForumWindow);
    
    
    /**
     * Funkcja sprawdzająca JS-ową walidację
     */
    var simpleValidation = function() {
        return true;
    }
    /**
     * Wstępna walidacja regulaminu oraz poprawności wpisanych obu haseł
     */
    $('#UserRegisterthis->Html').submit(simpleValidation);
</script>