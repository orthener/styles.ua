<?php $title = __d('public', 'PROGRAM PARTNERSKI'); ?>

<?php $this->set('title_for_layout', $title); ?>

<div id="my-account">
    <h1><?php echo $title ?></h1>
    <?php if (!empty($_SESSION['Auth']['User']['id'])): ?>
        <div class="blueNav">
            <?php echo $this->element('customer/menu'); ?>
        </div>
    <?php endif; ?>

    <div id="my-account-page">
        <?php echo $page['Page']['desc']; ?>
    </div>
    <div id="my-account-content" class="my-rabate-content">
        <?php //debug($affiliateDiscountForCustomer); ?>

        <table cellpadding="0" cellspacing="0">
            <tr>
                <th>NAZWA</th>
                <th>SUMARYCZNA WARTOŚĆ ZAMÓWIENIA (NETTO)</th>
                <th>RABAT</th>
            </tr>
            
            <?php foreach (@$affiliateLevels as $key => $level): ?>
                <?php
                if ((@$affiliateDiscountForCustomer['discount'] >= @$customer['Customer']['discount'])) {  
                    $class = ($level['AffiliateProgram']['id'] == @$affiliateDiscountForCustomer['id']) ? 'active ' : '';
                } else {
                    $class = '';
                }
                $class .= ( $key % 2 == 0) ? 'altrow' : '';
                ?>

                <tr <?php echo $class ? 'class="' . $class . '"' : ''; ?>>
                    <td><b><?php echo $level['AffiliateProgram']['name'] ?></b></td>                    
                    <td>od <?php echo $febNumber->priceFormat($level['AffiliateProgram']['minimum']); ?> obrotu</td>
                    <td><?php echo $level['AffiliateProgram']['discount'] ?>%</td>
                </tr>

            <?php endforeach; ?>
        </table>

        <?php
        if (!empty($_SESSION['Auth']['User']['id'])):
            
            $next = '';
            $tmp2 = 'kolejnego';

            if ($total > 0) {
                $next .= 'Sumatyczna wartość dotychczasowych transakcji <b>'.$febNumber->priceFormat($total).'</b>.';

            } else {
                $next .= 'Żadna z transakcji nie została jeszcze sfinalizowana.';
            }


            if ($customer['Customer']['discount'] == 0 && $total == 0) {
                $tmp2 = 'pierwszego';
            }

            $tmp = '';

            if (!empty($toNextLevel) && $toNextLevel > 0) {
                $next = $this->Html->div('desc', $next.' Do&nbsp;'.$tmp2.' progu rabatowego brakuje zamówień o&nbsp;minimalnej wartości <b>'.$febNumber->priceFormat($toNextLevel).'</b>.');
            } else {
                $next = $this->Html->div('desc', $next.' Posiadasz maksymalnie możliwy rabat.');
            }

            if ($customer['Customer']['discount'] > 0) {
                $tmp = 'Twój rabat: ' . $customer['Customer']['discount'] . '% (Indywidualny)';
            }
            ?>

            <?php
            if ($affiliateDiscountForCustomer['discount'] > $customer['Customer']['discount']) {
                echo $this->Html->div('orangeBigButton', 'Twój rabat: ' . $affiliateDiscountForCustomer['discount'] . '% (' . $affiliateDiscountForCustomer['name'] . ')' . $next);
            }

            if (($affiliateDiscountForCustomer['discount'] < $customer['Customer']['discount']) or (empty($affiliateDiscountForCustomer['discount']) and $customer['Customer']['discount'])) {
                echo $this->Html->div('orangeBigButton', $tmp . $next);
            }
        endif;
        ?>
    </div>

</div>