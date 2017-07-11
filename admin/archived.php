<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/website/core/init.php';
if (!is_looged_in()) {
  login_error_redirect();

}
include 'includes/head.php';
include 'includes/navigation.php';

//Restore Product

if(isset($_GET['restore'])) {

 $idz = sanitize($_GET['restore']);
 $db->query("UPDATE `products` SET `deleted`=0 WHERE `id`='$idz'");
 header('Location: archived.php');

}

?>

<?php

$sqlw = "SELECT * FROM `products` WHERE `deleted`=1";
$p_result = $db->query($sqlw);


?>

<h2 class="text-center">Archived Products</h2>
<div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed talbe-striped">
 <thead>
   <th>Restore</th>
   <th>Product</th>
   <th>Price</th>
   <th>Parent ~ Category</th>
   <th>Featured</th>
   <th>Sold</th>
 </thead>

 <tbody>

    <?php while($product = mysqli_fetch_assoc($p_result)) :

   $childID = $product['categories'];
   $catsql = "SELECT * FROM `categories` WHERE `id`='$childID'";
   $cat_result = $db->query($catsql);
   $child = mysqli_fetch_assoc($cat_result);
   $parentID = $child['parent'];
   $p_sql = "SELECT * FROM `categories` WHERE `id`='$parentID'";
   $presult = $db->query($p_sql);
   $parent = mysqli_fetch_assoc($presult);
   $category = $parent['category'].' ~ '.$child['category'];
   ?>


    <tr>
     <td>
      <a href="archived.php?restore=<?php echo $product['id']; ?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-repeat"></span></a>
     </td> <!-EDIT OR REMOVE ->

     <td><?php echo $product['title']; ?></td> <!-- TITLE -->
     <td><?php echo money($product['price']); ?></td> <!-- PRICE -->
     <td><?php echo $category; ?></td> <!-- Categories -->

     <td><a href="archived.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default">
       <span class="glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span>
     </a>&nbsp <?=(($product['featured'] == 1)?'Featured Product':'Add feature');?></td> <!-- FEATURED PRODUCT -->

     <td>0</td> <!-- SOLD -->

    </tr>
   <?php endwhile; ?>
 </tbody>

</table>



<?php include 'includes/footer.php'; ?>
