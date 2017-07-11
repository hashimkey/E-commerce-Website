<?php
define('BASEURL',$_SERVER['DOCUMENT_ROOT'].'/website/');

define('CART_COOKIE','SBwi7UCklwiqzz2');
define('CART_COOKIE_EXPIRE',time()+ (86400*30));

define('TAXRATE',0.084);

define('CURRENCY','usd');
define('CHECKOUTMODE','TEST');//change test to live when you are ready to go live

if(CHECKOUTMODE == 'TEST'){
  define('STRIPE_PRIVATE', 'sk_test_jKV9s2bJmBnSRSvboHnPZMdo');
  define('STRIPE_PUBLIC', 'pk_test_38XenL7BlBtuKNfJbJeYiT90');

}
if(CHECKOUTMODE == 'LIVE'){
  define('STRIPE_PRIVATE', 'sk_live_oy8o691axGRZluwjkS1b8hZg');
  define('STRIPE_PUBLIC' ,'pk_live_PKJdddORriSHZ3qSzuzJ9NbQ');

}

 ?>
