<?php
require __DIR__ . '/init.php';

if (isset($_POST['createaccount'])) {
  debug($_POST);
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  if (!DB::query('SELECT username FROM users WHERE username=:username', [':username' => $username])) {
    if (strlen($username) >= 3 && strlen($username) <= 32) {
      if (preg_match('/[a-zA-Z0-9_]+/', $username)) {
        if (strlen($password) >= 6 && strlen($password) <= 60) {
          if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (!DB::query('SELECT email FROM users WHERE email=:email', [':email' => $email])) {
              DB::query('INSERT INTO users VALUES (null, :username, :password, :email)', [':username' => $username, ':password' => password_hash($password, PASSWORD_BCRYPT), ':email' => $email]);
              echo 'Success!';
            } else {
              echo 'Email in use!';
            }
          } else {
            echo 'Invalid Email!';
          }
        } else {
          echo 'Password invalid!';
        }
      } else {
        echo 'Username invalid!';
      }
    } else {
      echo 'Username invalid!';
    }
  } else {
    echo 'User already exists!';
  }

}

?>

<h1>Create account</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <input type="text" name="username" placeholder="Username..." value="<?php echo $username; ?>"><br><br>
  <input type="password" name="password" placeholder="Password..." value="<?php echo $password; ?>"><br><br>
  <input type="email" name="email" placeholder="some@somesite.com" value="<?php echo $email; ?>"><br><br>
  <input type="submit" name="createaccount" value="Create Account">
</form>