<?php

//define('PRICE_NET', 0);
//define('PRICE_GROSS', 1);
//define('PRICE_TYPE', PRICE_GROSS); 

Configure::write('Payments.platnoscipl.pos', 'pos_147673');
Configure::write('Payments.platnoscipl.pos_147673', array(
    'pos_id'=>'147673',
    'pos_auth_key'=>'dLwGagC',
    'keyMD5'=>'ce0e59fa7cd44dca79effa37a2506fe8',
    '2keyMD5'=>'5355f685b3f92b507c48554b17f86687',
    'payGW' => "https://www.platnosci.pl/paygw/UTF/NewPayment",
));


?>