<?php
require __DIR__ . '/init.php';

if (isset($_POST['resetpassword'])) {
  $email = $_POST['email'];
  $cstrong = True;
  $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
  $user_id = DB::query('SELECT id FROM users WHERE email=:email', [':email' => $email])[0]['id'];
  DB::query('INSERT INTO password_tokens VALUES (null, :token, :user_id)', [':token' => sha1($token), ':user_id' => $user_id]);
  echo $token;
  echo '<br>';
  echo 'Email sent!';
}
?>

<h1>Forgot Password</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <input type="email" name="email" value="" placeholder="Email..."><br><br>
  <input type="submit" name="resetpassword" value="Reset Password">
</form>
