<? Php require_once $ _SERVER [ 'DOCUMENT_ROOT'] '/ e-commerce / core / init.php.';

$Product_id = isset ($_POST ['PRODUCT_ID']) aseptiser ($ _ POST [ 'PRODUCT_ID']): '';
 if(isset ($_POST ['product_id'])) {
   $product_id = sanitize ($_POST ['product_id']);
 }
  $ Taille = isset ($ _ POST [ 'SIZE']) aseptiser ($ _ POST [ 'TAILLE']): '';
  $ Disponible = isset ($ _ POST [ 'AVAILABLE']) aseptiser ($ _ POST [ 'AVAILABLE']): '';
  $ QUANTITÉ = isset ($ _ POST [ 'QUANTITÉ']) aseptiser ($ _ POST [ 'QUANTITÉ']): '';
  $ Item = array ();
  $ Point [] = array (
    'id' => $ product_id,
    'SIZE' => $ size,
    'QUANTITÉ' => $ quantity
  );
    $Domain = (($_SERVER [ 'DOCUMENT_ROOT'] = 'localhost') $ _ SERVER [ 'DOCUMENT_ROOT'] !? :. False '.');
    $Domain = ($_SERVER [ 'HTTP_HOST']! = 'Localhost')? '.' . $ _ SERVER [ 'HTTP_HOST']: false;
    $Query = $ db-> query ( "SELECT * FROM WHERE Produits id = '{$ product_id}'");
    $ Produit = mysqli_fetch_assoc ($ query);
     $ _SESSION [ 'Success_flash'] = $ product [ 'title']. 'A a été ajouté à Votre panier.';
     Vérifiez si le témoin du panier existe si
     $ cartQ = $ db-> query ( "SELECT * FROM panier WHERE id = () {$ cart_id}'") is_array ($ cart_id = '!)';
     $ = Mysqli_fetch_assoc Panier ($ cartQ);
     $ PREVIOUS_ITEMS = json_decode ($ panier [ 'articles'], true);
     $ Item_match = 0;
     $ New_items = array ();
     foreach ($ PREVIOUS_ITEMS Que $ pItem) {
       if ($ item [0] [ 'id'] == $ pItem [ 'id'] && $ item [0] [ 'size'] == $ pItem [ 'SIZE'] ) {
         $ pItem [ 'Quantity'] = $ pItem [ 'Quantity'] + $ item [0] [ 'Quantity'];
         if ($ pItem [ 'Quantity']> $ disponible) {
           $ pItem [ 'Quantity'] = $ DISPONIBLES;
          }
          $ Item_match = 1;
        }
         $ New_items [] = $ pItem;
       }
        Si (item_match $ = 1!) {
          $ New_items = array_merge ($ item, $ PREVIOUS_ITEMS);
        } $ Items_json = json_encode (new_items $);
        $ Cart_expire = date ( "Ymd H: i: s", strtotime ( "+ 30 jours"));
        $ Db-> query ( "articles UPDATE panier SET = '{items_json $}', expire_date = '{$ cart_expire}' WHERE id = '{$ cart_id}'");
        setcookie (CART_COOKIE, '', 1, "/", $ domain, false);
        setcookie (CART_COOKIE, $ cart_id, CART_COOKIE_EXPIRE, '/', $ domain, false);
      } Else {
        // Ajoutez le panier à la BASE DE DONNEES et définissez le biscuit
         $ items_json = json_encode ($ item);
         $ Cart_expire = date ( "Ymd H: i: s", strtotime ( "+ 30 jours"));
         $ Db-> query ( "INSERT INTO panier (articles, EXPIRE_DATE) VALUES ( '{items_json $}', '{$ cart_expire}')");

         $ Cart_id = $ db-> insert_id;
         setcookie (CART_COOKIE, $ cart_id, CART_COOKIE_EXPIRE, '/', $ domain, false);
       }?>﻿























       <?php
       require_once 'core/init.php';
       include 'includes/head.php';
       include 'includes/navigation.php';
       include 'includes/header.php';

       if($cart_id != ''){
         $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
         $result = mysqli_fetch_assoc($cartQ);
         $items = json_decode($result['items'],true);
         $i = 1;
         $sub_total = 0;
         $item_count = 0;
       }
       ?>



       <div class="col-md-12">
         <div class="row">
           <h2 class="text-center">My Shopping Cart</h2><hr>
           <?php if($cart_id == ''): ?>
             <div class="bg-danger">
               <p class="text-danger text-center">
                 Your shopping cart is empty!
               </p>
             </div>
           <?php else: ?>
             <table class="table table-bordered table-condensed table-striped">
              <thead><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th></thead>
              <tbody>
               <?php

                  foreach ($items as $item) {
                    $product_id = $item['id'];
                    $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
                    $product = mysqli_fetch_assoc($productQ);
                    $sArray = explode(',',$product['sizes']);
                    foreach ($sArray as $sizeString) {
                      $s = explode(':',$sizeString);
                      if($s[0] == $item['size']){
                        $available =$s[1];
                      }
                    }
                    ?>
                    <tr>
                      <td><?=$i;?></td>
                      <td><?=$product['title'];?></td>
                      <td><?=money($product['price']);?></td>

                      </tr>
                      <?php } ?>


                        </tbody>
                      </table>
                      <?php endif;?>
          </div>

        </div>

        <?php include 'includes/footer.php';  ?>
