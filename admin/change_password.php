<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/website/core/init.php';
if (!is_looged_in()) {
  login_error_redirect();

}
include  'includes/head.php';



//password

//$hashed = password_hash($password,PASSWORD_DEFAULT);
$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);

$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);

$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);

$new_hashed = password_hash($password,PASSWORD_DEFAULT);
$user_id = $user_data['id'];

$errors= array();



?>
<div id="login_form">
  <div>
    <?php
    if($_POST){
    //form validaton
    if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
    $errors[] = 'You must fill all the fields';

    }

    //password must be more than 6 characters
    if (strlen($password) < 6) {
      $errors[] = 'Password must be more than 6 characters';
    }
    //if new password matches  confirm
    if ($password != $confirm) {
        $errors[] = 'New password and confirm password does not match!';
    }
    if (password_verify($old_password,$hashed)) {
        $errors[] = 'The old password does not match our record';

    }

    //check for errors
    if (!empty($errors)) {
      echo display_errors($errors);
    }else {
        $db->query("UPDATE users SET password '$new_hashed' WHERE id = '$user_id'");
        $_SESSION['success_flash'] = 'your password has been updated';
        header('Location: index.php');
    }
}
     ?>

  </div>
  <h2 class="text-center">Change Password</h2>
  <form class="" action="change_password.php" method="post">
    <div class="form-group">
      <label for="old_password">Old password: </label>
      <input type="password" name="old_password"  id="old_password" class="form-control" value="<?= $old_password ;?>" placeholder="old password">
    </div>

    <div class="form-group">
      <label for="password">New Password: </label>
      <input type="password" name="password"  id="password" class="form-control" value="<?= $password ;?>" placeholder="New Password">
    </div>

    <div class="form-group">
      <label for="confirm">Confirm New Password: </label>
      <input type="password" name="confirm"  id="confirm" class="form-control" value="<?= $confirm ;?>" placeholder="Confirm New password">
    </div>

    <div class="form-group">
      <a href="index.php" class="btn btn-default">Cancel</a>
      <input type="submit" name="" value="Login" class="btn btn-primary btn-ceneter">
    </div>


  </form>
  <p class="text-right"><a href="/website/index.php" alt="home">Visit Site</a></p>
</div>


<?php include 'includes/footer.php'; ?>
