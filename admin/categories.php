<?php

//require_once $_SERVER['DOCUMENT_ROOT'].'/website/core/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/website/core/init.php';
if (!is_looged_in()) {
  login_error_redirect();

}
include  'includes/head.php';
include 'includes/navigation.php';


$sql = "SELECT * FROM categories WHERE parent = 0";
$result = $db->query($sql);
$error = array();
$category = '';
$post_parent = '';
$edit_category = '';



//Edit categpories
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
  $edit_id = (int)$_GET['edit'];
  $edit_id = sanitize($edit_id);
  $sql2 = "SELECT * FROM categories WHERE id = '$edit_id'";
  $edit_result =$db->query($sql2);
  $edit_category = mysqli_fetch_assoc($edit_result);
}


//Delete Category
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
 $delete_id = (int)$_GET['delete'];
  $delete_id = sanitize($delete_id);
  $dsql = "DELETE FROM categories WHERE id = '{$delete_id}' OR parent ='{$delete_id}'";
   $db->query($dsql);

   header('Location: categories.php');

}

//Process form
if (isset($_POST) && !empty($_POST)) {
  $post_parent = sanitize($_POST['parent']);
  $category = sanitize($_POST['category']);
  $sql_form = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent'";

  if (isset($_GET['edit'])) {
    $id = $edit_category['id'];
    $sql_form = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id  != '$id'";

  }

  $form_result = $db->query($sql_form);
  $count = mysqli_num_rows($form_result);

  //if category is blank
  if ($category == '') {
    $error[].= ' The category name can not be blank';

  }
  //if exist in the Database
  if ($count > 0) {
  $error[].= $category. ' Already exist.Please choose another category name';


  }

  //Display errors or update Database

  if (!empty($error)) {
  //Display the error
    //echo display_errors($error);
   $display = display_errors($error);  ?>

  <script>
  jQuery('document').ready(function(){
  jQuery('#error').html('<?php echo $display ; ?>');
  });

  </script>
  <?php
}else {
  //Update Database
  $update_sql =  "INSERT INTO categories (category,parent) VALUES ('$category','$post_parent')";
  if (isset($_GET['edit'])) {
    $update_sql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
  }
  $db->query($update_sql);
  header('Location : categories.php');
  }



}

$category_value = '';
$parent_value = 0;
if (isset($_GET['edit'])) {
  $category_value = $edit_category['category'];
  $parent_value = $edit_category['parent'];
}else {
  if (isset($_POST['edit'])) {
    $category_value = $category ;
    $parent_value = $post_parent;
  }
}

 ?>
<h2 class="text-center">Categories</h2><hr>
<div class="row">
  <!-- Form-->
  <div class="col-md-6">

    <form class="form" action="categories.php<?php echo ((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <legend><?php echo ((isset($_GET['edit']))?'Edit ':'Add ');?> Category</legend>

      <div class="" id="error"> </div>
      <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-control" name="parent" id="parent">
          <option value="0"<?php echo (($parent_value == 0)?' Selected="Selected"':'');?>>parent</option>
          <?php while ($parent = mysqli_fetch_assoc($result)) :?>
            <option value="<?php echo $parent['id'];?>"<?php echo (($parent_value == $parent['id'])?' Selected="Selected" ':'');?>><?php echo $parent['category'];?></option>
          <?php endwhile ; ?>

        </select>

      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" value="<?= $category_value; ?>" class="form-control" id="category">

      </div>
      <div class="form-group" >
        <input type="submit" name="" value="<?php echo ((isset($_GET['edit']))?'Edit ':'Add');?> category" class="btn btn-success">

      </div>

    </form>

  </div>
  <!-- categories table -->
  <div class="col-md-6">
    <table class="table table-bordered">
      <thead>
        <th>Category</th>
        <th>Parent</th>
        <th></th>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM categories WHERE parent = 0";
        $result = $db->query($sql);
        while ($parent = mysqli_fetch_assoc($result)) :
          $parent_id = (int)$parent['id'];
          $sql_child = "SELECT * FROM categories WHERE parent = '$parent_id'";
          $child_result = $db->query($sql_child);
          ?>
        <tr class="bg-primary">
          <td><?php echo $parent['category']; ?></td>
            <td>Parent</td>
              <td>
                <a href="categories.php?edit=<?php echo $parent['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="categories.php?delete=<?php echo $parent['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
              </td>

        </tr>
        <?php   while ($child = mysqli_fetch_assoc($child_result)) :?>
          <tr class="bg-info">
            <td><?php echo $child['category']; ?></td>
              <td><?php echo $parent['category']; ?></td>
                <td>
                  <a href="categories.php?edit=<?php echo $child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                  <a href="categories.php?delete=<?php echo $child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
                </td>

          </tr>

        <?php endwhile ;?>

      <?php endwhile; ?>
      </tbody>


    </table>

  </div>

</div>
 <?php
include 'includes/footer.php';
  ?>
