<?php echo __("Witaj",true)."!" ?> 

<?php echo sprintf(__("Płatność przebiegła pomyślnie!", true)); ?> 

<?php echo sprintf(__("Kwota płatności: %s ₴", true), $user['Payment']['amount']); ?> 

<?php echo sprintf(__("Tytuł płatności: %s.", true), $user['Payment']['title']); ?> 

<?php echo __("Dziękujemy za skorzystanie z naszej oferty", true); ?> 