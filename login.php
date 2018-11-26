<?php
require __DIR__ . '/init.php';

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (DB::query('SELECT username FROM users WHERE username=:username', [':username' => $username])) {
    if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', [':username' => $username])[0]['password'])) {
      $cstrong = True;
      $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
      $user_id = DB::query('SELECT id FROM users WHERE username=:username', [':username' => $username])[0]['id'];
      DB::query('INSERT INTO login_tokens VALUES (null, :token, :user_id)', [':token' => sha1($token), ':user_id' => $user_id]);
      setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
      setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
      header('Location: index.php');
      echo 'Login In!';

    } else {
      echo 'Password incorrect!';
    }
  } else {
    echo 'User not registered!';
  }
}
?>
<h1>Login to your account</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <input type="text" name="username" placeholder="Username..." value="<?php if (isset($username)) echo $username; ?>"><br><br>
  <input type="password" name="password" placeholder="Password..." value="<?php if (isset($password)) echo $password; ?>"><br><br>
  <input type="submit" name="login" value="Login">
</form>
