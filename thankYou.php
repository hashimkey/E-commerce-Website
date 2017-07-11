<?php
require_once 'core/init.php';





// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);



// Token is created using Stripe.js or Checkout!
// Get the payment token submitted by the form:
//$token = $_POST['stripeToken'];


$token= isset($_POST['stripeToken'])? sanitize($_POST['stripeToken']):'';
//get the rest of the post data
$full_name = isset($_POST['full_name'])? sanitize($_POST['full_name']):'';
$email = isset($_POST['email'])? sanitize($_POST['email']):'';
$street = isset($_POST['street'])? sanitize($_POST['street']):'';
$street2 = isset($_POST['street2'])? sanitize($_POST['street2']):'';
$city = isset($_POST['city'])? sanitize($_POST['city']):'';
$state = isset($_POST['state'])? sanitize($_POST['state']):'';
$zip_code = isset($_POST['zip_code'])? sanitize($_POST['zip_code']):'';
$country = isset($_POST['country'])? sanitize($_POST['country']):'';

$tax = isset($_POST['tax'])? sanitize($_POST['tax']):'';
$sub_total = isset($_POST['sub_total'])? sanitize($_POST['sub_total']):'';
$grand_total = isset($_POST['grand_total'])? sanitize($_POST['grand_total']):'';
$cart_id = isset($_POST['cart_id'])? sanitize($_POST['cart_id']):'';
$description = isset($_POST['description'])? sanitize($_POST['description']):'';
$charge_amount =number_format($grand_total,2)*100;
$metadata = array(
      "cart_id"    => $cart_id,
      "tax"        => $tax,
      "sub_total"    => $sub_total
);
try{
// Charge the user's card:
$charge = \Stripe\Charge::create(array(
  "amount" => $charge_amount,
  "currency" => CURRENCY,
  "source" => $token,
  "description" => $description,
  "receipt_email" => $email,
  "metadata"   => $metadata)


);

//Adjust invetory
$itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$iresult = mysqli_fetch_assoc($itemQ);
$items = json_decode($iresult['items'],true);
foreach ($items as $item) {
  $newSizes = array();
  $item_id = $item['id'];
  $productQ = $db->query("SELECT sizes FROM products WHERE id = '{$item_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $sizes = sizesToArray($product['sizes']);
  foreach ($sizes as $size) {
    if ($size['size'] == $item['size']) {
      $q = $size['quantity'] - $item['quantity'];
      $newSizes[] = array('size' => $size['size'], 'quantity' => $q);


    }else {
      $newSizes[] = array('size' => $size['size'], 'quantity' => $size['quantity']);
    }
  }

    $sizeString = sizesToString($newSizes);
    $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
}
//Update cart
$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
$db->query("INSERT INTO
  transactions (charged_id,cart_id,full_name,email,street,street2,city,state,zip_code,country,sub_total,tax,grand_total,description,txn_type)
  VALUES('$charge->id','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$country','$sub_total','$tax','$grand_total','$description','$charge->object')");

  $domain = false;
  setcookie(CART_COOKIE,'',1,'/',$domain,false);
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/header.php';


?>
<h1 class="text-center text-success">Thank you</h1>
<p>Your card has been successfully charged <?php echo money($grand_total); ?>. You have been emailed a receipt.please check your spam folder if it is not in your inbox.You can also print this page as a receipt.</p>
<p>Your receipt number is : <strong><?php echo $cart_id; ?></strong></p>
<p>Your order will be shipped in the address below:</p>
<address class="">
  <?= $full_name;?><br>
  <?=$street; ?><br>
  <?= (($street2 != '')?$street2.'<br>':'');?>
  <?=$city.' '.$state. ' '.$zip_code ;  ?><br>
  <?= $country;?><br>
</address>
<?php

include 'includes/footer.php';

}catch(\Stripe\Error\Card $e){
  echo $e;

}

 ?>
