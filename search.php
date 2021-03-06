<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/header.php';
include 'includes/leftbar.php';

$sql = "SELECT * FROM products";
$cat_id =  ((isset($_POST['cat']) && $_POST['cat'] != '')?sanitize($_POST['cat']): '');
if ($cat_id == '') {
  $sql .=  " WHERE deleted = 0";
}else {
  $sql .= " WHERE categories = '{$cart_id}' AND deleted = 0";
}

$price_sort  = ((isset($_POST['price_sort']) && $_POST['price_sort'] != '')?sanitize($_POST['price_sort']): '');
$min_price   = ((isset($_POST['min_price']) && $_POST['min_price'] != '')?sanitize($_POST['max_price']): '');
$max_price   = ((isset($_POST['max_price']) && $_POST['max_price'] != '')?sanitize($_POST['max_price']): '');
$brand       = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']): '');

if ($min_price != '') {
  $sql .= " AND price >= '{$min_price}'";
}
if ($max_price != '') {
  $sql .= " AND price <= '{$max_price}'";
}

if ($brand != '') {
  $sql .= " AND brand = '{$brand}'";
}
if ($price_sort == 'low') {
    $sql .= " ORDER BY price";
}
if ($price_sort == 'high') {
    $sql .= " ORDER BY price DESC";
}
$catQuery = $db->query($sql);
$categry = get_category($cat_id);

 ?>



    <!-- Main content -->
    <div class="col-md-8">
      <div class="row">
        <?php if($cat_id != ''): ?>
        <h2 class="text-center"><?= $categry['parent'].' '.$categry['child'];?></h2>
      <?php else: ?>
        <h2 class="text-center">Website Name</h2>
      <?php endif; ?>
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
