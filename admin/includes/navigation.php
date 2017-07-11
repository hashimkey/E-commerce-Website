


<!-- Top nav bar -->

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
    <a class="navbar-brand" href="/website/admin/index.php">Basra Design Admin</a>
  </div>


  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-left">


<li><a href="brands.php">brands</a></li>
<li><a href="categories.php">categories</a></li>
<li><a href="products.php">Products</a></li>
<li><a href="archived.php">archived</a></li>
<?php if (has_permission('admin')) : ?>
<li><a href="users.php">Users</a></li>
<?php endif;?>
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown"  >Hello <?= $user_data['first']; ?><span class="caret"></span</a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="change_password.php">Change Password</a></li>
      <li><a href="logout.php">Logout</a></li>
      <li><a href="#"></a></li>
      <li><a href="#"></a></li>
      <li><a href="#"></a></li>
    </ul>
</li>

<!--
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"  ><?php echo $parent['category']; ?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#"></a></li>


        </ul>
      </li>
    -->

    </ul>
  <!--  <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php">Login</a></li>
    </ul> -->

  </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
