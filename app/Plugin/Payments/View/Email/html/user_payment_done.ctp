<p><big><?php echo __("Witaj",true)."!" ?></big></p>
<p>&nbsp;</p>
<p><b><?php echo sprintf(__("Płatność przebiegła pomyślnie!", true)); ?></b></p> 
<p>&nbsp;</p>
<p><?php echo sprintf(__("Kwota płatności: %s ₴", true), $user['Payment']['amount']); ?></p> 
<p>&nbsp;</p>
<p><?php echo sprintf(__("Tytuł płatności: %s.", true), $user['Payment']['title']); ?></p> 
<p>&nbsp;</p>
<p><?php echo __("Dziękujemy za skorzystanie z naszej oferty", true); ?></p>

