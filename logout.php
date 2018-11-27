<?php
require __DIR__ . '/init.php';

if (!Login::isLoggedIn()) {
  die('Not login!');
}
if (isset($_POST['confirm'])) {

  if (isset($_POST['alldevices'])) {
    DB::query('DELETE FROM login_tokens WHERE user_id=:userid', [':userid' => Login::isLoggedIn()]);
    header('Location: login.php');
  } else {
    if (isset($_COOKIE['SNID'])) {
      DB::query('DELETE FROM login_tokens WHERE token=:token', [':token' => sha1($_COOKIE['SNID'])]);
      header('Location: login.php');
    }
    setcookie('SNID', '1', time() - 3600);
    setcookie('SNID_', '1', time() - 3600);
  }
}

?>

<h1>Logout of your Account?</h1>
<p>Are you sure you'd like logout?</p>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <input type="checkbox" name="alldevices" value="alldevices"> Logout of all devices?<br>
  <input type="submit" name="confirm" value="Confirm">
</form>
