<?php echo __("Witaj",true)."!" ?> 

<?php echo sprintf(__("O godzinie %s dnia %s została rozpoczęta płatność. Szczegóły:", true), date('H:i', strtotime($user['Payment']['created'])), date('j.m.Y', strtotime($user['Payment']['created']))); ?> 

<?php echo sprintf(__("Kwota płatności: %s ₴", true), $user['Payment']['amount']); ?> 

<?php echo sprintf(__("Tytuł płatności: %s.", true), $user['Payment']['title']); ?> 

<?php echo __('Status ustalony przez bramkę płatności:', true) ?> 

         <?php echo $user['Payment']['error']; ?> 

<?php echo __('W razie problemów, prosimy o przesłanie formularzem kontaktowym
zgłoszenia zawierającego datę i godzinę transakcji, swoje dane używane podczas płatności
oraz treść powyższego komunikatu.', true); ?> 