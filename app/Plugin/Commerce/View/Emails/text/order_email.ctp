<?php echo __("Witaj",true)."!" ?> 

<?php echo sprintf(__("Płatność przebiegła pomyślnie!")); ?> 

<?php echo sprintf(__("Kwota płatności: %s ₴"), $user['Payment']['amount']); ?> 

<?php echo sprintf(__("Tytuł płatności: %s."), $user['Payment']['title']); ?> 

<?php echo __("Dziękujemy za skorzystanie z naszej oferty"); ?> 