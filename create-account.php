<?php
require __DIR__ . '/init.php';

if (isset($_POST['createaccount'])) {
  debug($_POST);
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  DB::query('INSERT INTO users VALUES (null, :username, :password, :email)', [':username' => $username, ':password' => $password, ':email' => $email]);
  echo 'Success!';
}

?>

<h1>Create account</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <input type="text" name="username" placeholder="Username..." value=""><br><br>
  <input type="password" name="password" placeholder="Password..." value=""><br><br>
  <input type="email" name="email" placeholder="some@somesite.com" value=""><br><br>
  <input type="submit" name="createaccount" value="Create Account">
</form>