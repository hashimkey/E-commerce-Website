<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/website/core/init.php';
include  'includes/head.php';


//password

//$hashed = password_hash($password,PASSWORD_DEFAULT);

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);

$errors= array();



?>
<style>

body{
  position: relative;
  padding: 0;
  padding-top: 0x;
  margin-top: 100px;
  overflow: hidden;

  height: 600px;
background-image: url("/website/images/headerLogo/background.png");
background-repeat: no-repeat;
background-size: 100vw 100vh;
background-color:;
background-position: top center;
background-attachment: fixed;
}
#login_form{
  width: 50%;
  height: 60%;
  border: 2px solid #000;
  border-radius: 15px;
  box-shadow: 7px 7px 15px rgba(0, 0, 0, 0.5);
  margin: 8px auto;
  padding: 15px;
}

</style>

<div id="login_form">
  <div>
    <?php
    if($_POST){
    //form validaton
    if (empty($_POST['email']) || empty($_POST['password'])) {
    $errors[] = 'You must provide the email and password';

    }
    //validate email
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'You must enter a valid email';
    }
    //password must be more than 6 characters
    if (strlen($password) < 6) {
      $errors[] = 'Password must be more than 6 characters';
    }
    //check if email exist in the Database
    $query = $db->query("SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($query);
    $userCount = mysqli_num_rows($query);
    if ($userCount < 1) {
      $errors[] = 'that email doesn\'t exist in our database';

    }
    if (password_verify($password,$user['password'])) {
        $errors[] = 'The password doesn\'t match our record';

    }

    //check for errors
    if (!empty($errors)) {
      echo display_errors($errors);
    }else {
      $user_id = $user['id'];
      login($user_id);
    }
}
     ?>

  </div>
  <h2 class="text-center">Login</h2>
  <form class="" action="login.php" method="post">
    <div class="form-group">
      <label for="email">Email: </label>
      <input type="email" name="email"  id="email" class="form-control" value="<?= $email ;?>" placeholder="Email">
    </div>

    <div class="form-group">
      <label for="password">Password: </label>
      <input type="password" name="password"  id="password" class="form-control" value="<?= $password ;?>" placeholder="Password">
    </div>

    <div class="form-group">
      <input type="submit" name="" value="Login" class="btn btn-primary btn-ceneter">
    </div>


  </form>
  <p class="text-right"><a href="/website/index.php" alt="home">Visit Site</a></p>
</div>


<?php include 'includes/footer.php'; ?>
