<?php
require_once 'core/init.php';


$sql ="SELECT * FROM categories WHERE parent = 0";
$query = $db->query($sql);

 ?>



<!-- Top nav bar -->
<div class="navbar-wrapper">
<nav class="navbar navbar-default">
<div class="container-fluid">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php">Fashion Design</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-left">

      <?php while($parent = mysqli_fetch_assoc($query)) : ?>

        <?php
         $parent_id = $parent['id'];
         $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
         $query2 = $db->query($sql2);
          ?>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"  ><?php echo $parent['category']; ?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <?php while($child = mysqli_fetch_assoc($query2)): ?>
          <li><a href="category.php?cat=<?= $child['id'];?>"><?php echo $child['category'] ?></a></li>
        <?php endwhile; ?>


        </ul>
      </li>
      <?php endwhile;  ?>
      <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>My cart</a></li>

    </ul>

  </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

</div>
