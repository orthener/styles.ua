<p><big><?php echo __("Witaj",true)."!" ?></big></p>
<p>&nbsp;</p>
<p><b><?php echo sprintf(__("O godzinie %s dnia %s została rozpoczęta płatność. Szczegóły:", true), date('H:i', strtotime($user['Payment']['created'])), date('j.m.Y', strtotime($user['Payment']['created']))); ?> </b></p>
<p>&nbsp;</p>
<p><?php echo sprintf(__("Kwota płatności: %s ₴", true), $user['Payment']['amount']); ?></p> 
<p>&nbsp;</p>
<p><?php echo sprintf(__("Tytuł płatności: %s.", true), $user['Payment']['title']); ?></p> 
<p>&nbsp;</p>
<p><?php echo __('Status ustalony przez bramkę płatności:', true) ?></p>

         <b><?php echo $user['Payment']['error']; ?></b>
<p>&nbsp;</p>
<p><?php echo __('W razie problemów, prosimy o przesłanie formularzem kontaktowym<br />
zgłoszenia zawierającego datę i godzinę transakcji, swoje dane używane podczas płatności<br />
oraz treść powyższego komunikatu.', true); ?></p>

