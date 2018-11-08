<?php
require __DIR__ . '/init.php';
$tokenIsValid = false;

if (Login::isLoggedIn()) {
  if (isset($_POST['changepassword'])) {
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
  if (isset($_GET['token'])) {
    $token = $_GET['token'];
    if (DB::query('SELECT user_id FROM password_tokens WHERE token=:token', [':token' => sha1($token)])) {
      $userid = DB::query('SELECT user_id FROM password_tokens WHERE token=:token', [':token' => sha1($token)])[0]['user_id'];
      $tokenIsValid = true;
      if (isset($_POST['changepassword'])) {
        $newpassword = $_POST['newpassword'];
        $newpasswordrepeat = $_POST['newpasswordrepeat'];
        if ($newpassword == $newpasswordrepeat) {
          if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
            DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', [':newpassword' => password_hash($newpassword, PASSWORD_BCRYPT), ':userid' => $userid]);
            echo 'Password change successfully!';
            DB::query('DELETE FROM password_tokens WHERE user_id=:userid', [':userid' => $userid]);
          } else {
            echo 'Password invalid!';
          }
        } else {
          echo 'Passwords dont\'t match';
        }
      }
    } else {
      die('Token invalid!');
    }
  } else {
    die('Not logged in');
  }
}
?>
<h1>Change your Password</h1>
<form action="<?php if (!$tokenIsValid) { echo $_SERVER['PHP_SELF']; } else {echo $_SERVER['PHP_SELF'] . '?token=' . $token; } ?>" method="post">
  <?php if (!$tokenIsValid) {?>
  <input type="password" name="oldpassword" value="<?php if (isset($oldpassword)) echo $oldpassword; ?>" placeholder="Current Password..."><br><br>
  <?php }?>
  <input type="password" name="newpassword" value="" placeholder="New Password..."><br><br>
  <input type="password" name="newpasswordrepeat" value="" placeholder="Repeat Password..."><br><br>
  <input type="submit" name="changepassword" value="Change Password">
</form>