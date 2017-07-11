

<?php
  $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']): '');
  $price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']): '');
  $min_price  =  ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']): '');
  $max_price  = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']): '');
          $b  =  ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']): '');

  $brandQ = $db->query("SELECT * FROM brand ORDER BY brand");

 ?>

 </style>
<h3 class="text-left ">Search by:</h3>
 <h4 class="text-left">Price:</h4>

 <form class="" action="search.php" method="post">
   <input type="hidden" name="cat" value="<?= $cat_id;?>">
   <input type="hidden" name="price_sort" value="0">
   <input type="radio" name="price_sort" value="low"<?=(($price_sort == 'low')?' checked':'');?>>Low to High <br>
   <input type="radio" name="price_sort" value="high"<?=(($price_sort == 'high')?' checked':'');?>>High to Low <br> <br>
   <input type="text" name="min_price" class="price-range" placeholder="min $" value="<?=$min_price;?>" style="width:55px;"> To
   <input type="text" name="max_price" class="price-range" placeholder="max $" value="<?=$max_price;?>" style="width:55px;"> <br> <br>

   <h4 class="text-left">Brand:</h4>
   <input type="radio" name="brand" value="<?=(($b == '')?' checked':'');?>"> All <br>
   <?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
     <input type="radio" name="brand" value="<?= $brand['id'];?>"<?=(($b == $brand['id'])?' checked': '');?>><?= $brand['brand'];?> <br>
  <?php endwhile ; ?>

  <input type="submit" name="" value="search" class="btn btn-xs btn-primary">

 </form>
