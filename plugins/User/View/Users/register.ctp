<?php $this->set('title_for_layout', __d('cms', 'Rejestracja')); ?>
<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('public', 'Rejestracja')); ?>
<div class="container">
    <div class="row-fluid">
        <div class="breadcrump span8 my-span8 bt-no-margin">
                <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
</div>
<div class="white-background register clearfix">
    <div class="clearfix">
        <div class="border-page padding20 clearfix registers">

            <div class="title clearfix">
                <h1><?php echo __d('cms', 'Rejestracja'); ?></h1>
            </div>
            <?php
            echo $this->Form->create('User');
            echo $this->Form->input('email', array('label' => __d('front', 'E-mail')));
            echo $this->Form->input('name', array('label' => __d('front', 'Nazwa użytkownika')));
            //echo $this->Form->input('newpassword', array('label' => __d('public', 'Hasło'), 'type'=>'password'));
            //echo $this->Form->input('confirmpassword', array('label' => __d('public', 'Powtórz hasło'), 'type'=>'password'));
            $rules_link = $this->Html->link(__d('public', 'Regulaminem'), array('controller' => 'pages', 'plugin'=>'page', 'action' => 'view', 'regulamin'));
            $privacy_policy_link = $this->Html->link(__d('public', 'Polityką prywatności'), array('plugin'=>'page', 'controller' => 'pages', 'action' => 'view', 'polityka-prywatnosci'));
            $label = sprintf(__d('front', 'Oświadczam, że zapoznałem się z %s oraz %s, rozumiem je i zobowiązuje sie je przestrzegać.'), $rules_link, $privacy_policy_link);
            ?>
            <div class="actionLogin">
                <?php
                echo $this->Form->input('rules', array('type' => 'checkbox', 'label' => $label));
                ?>
            </div>
            <?php
            echo $this->Form->submit(__d('front', 'Zarejestruj się'),array('class'=>'btnBlueWhite button black white-text'));
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>

<!--Skrypt do prostej jsowej wlidacji-->
<script type="text/javascript">
//
//   WERSJA Z REGULAMINEM POP-UP
//
//    var rulesWindow = function () {
//        window.open('<?php //echo $this->Html->url(array('pop_up_rules'));    ?>', 'Regulamin', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=640,height=530').focus();
//        return false
//    }
//    var privacyPolicyWindow = function () {
//        window.open('<?php //echo $this->Html->url(array('pop_up_privacy_policy'));    ?>', 'Regulamin', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=640,height=530').focus();
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

<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function() {
//        $('input').iCheck({
//            checkboxClass: 'icheckbox_minimal',
//            radioClass: 'iradio_minimal'
//        });

        $('label a[href]').click(function(e) {

            e.preventDefault();

            if (this.getAttribute('target') === '_blank') {
                window.open(this.href, '_blank');
            }
            else {
                window.open(this.href, '_blank');
            }
        });

    });
    //]]>
</script>