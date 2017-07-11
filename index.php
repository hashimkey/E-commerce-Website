
<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';
include 'includes/leftbar.php';


$sql = "SELECT * FROM products WHERE featured = 1";
$featuredQuery = $db->query($sql);

 ?>



    <!-- Main content -->
    <div class="col-md-8">
      <div class="row">
              <h2 class="text-center"></h2>
        <?php while($product = mysqli_fetch_assoc($featuredQuery)): ?>

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
