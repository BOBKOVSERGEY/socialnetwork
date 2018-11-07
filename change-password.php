<?php
require __DIR__ . '/init.php';



if (Login::isLoggedIn()) {
  if (isset($_POST['changepassword'])) {
    debug($_POST);
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $newpasswordrepeat = $_POST['newpasswordrepeat'];
    if (password_verify($oldpassword, DB::query('SELECT password FROM users WHERE id=:userid', [':userid' => Login::isLoggedIn()])[0]['password'])) {
      if ($newpassword == $newpasswordrepeat) {
        if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
          DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', [':newpassword' => password_hash($newpassword, PASSWORD_BCRYPT), ':userid' => Login::isLoggedIn()]);
          echo 'Password change successfully!';
        } else {
          echo 'Password invalid!';
        }
      } else {
        echo 'Passwords dont\'t match';
      }
    } else {
      echo 'Incorrect old Password';
    }
  }
} else {
  die('Not logged in');
}
?>
<h1>Change your Password</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="password" name="oldpassword" value="<?php if (isset($oldpassword)) echo $oldpassword; ?>" placeholder="Current Password..."><br><br>
  <input type="password" name="newpassword" value="" placeholder="New Password..."><br><br>
  <input type="password" name="newpasswordrepeat" value="" placeholder="Repeat Password..."><br><br>
  <input type="submit" name="changepassword" value="Change Password">
</form>