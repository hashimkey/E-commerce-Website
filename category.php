<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/header.php';
include 'includes/leftbar.php';


if (isset($_GET['cat'])) {
  $cat_id = sanitize($_GET['cat']);
}else {
  $cat_id = '';
}

$sql = "SELECT * FROM products WHERE categories = '$cat_id'";
$catQuery = $db->query($sql);
$categry = get_category($cat_id);

 ?>



    <!-- Main content -->
    <div class="col-md-8">
      <div class="row">
        <h2 class="text-center"><?= $categry['parent'].' '.$categry['child'];?></h2>
        <?php while($product = mysqli_fetch_assoc($catQuery)): ?>
        <div class="col-md-3">
          <h4><?php echo $product['title'] ;?></h4>
            <?php $photos = explode(',',$product['image']); ?>
          <img src="<?php echo $photos[0] ;?>" alt="<?php echo $product['title'] ;?>" class="img-thumb"/>
          <p class="list-price text-danger">list price <s>$ <?php echo $product['list_price'] ?></s></p>
          <p class="price">Our price:  $ <?php echo $product['price'] ?></p>
          <button type="button" name="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id'];?>)">Details</button>

        </div>
      <?php endwhile ;  ?>

      </div>
  </div>




<?php


include 'includes/rightbar.php';
include 'includes/footer.php';

 ?>
