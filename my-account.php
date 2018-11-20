<?php
require __DIR__ . '/init.php';

if (Login::isLoggedIn()) {
  $userid = Login::isLoggedIn();
} else {
  die('Not logged in!');
}

if (isset($_POST['uploadprofileimg'])) {

  Image::uploadImage('profileimg','UPDATE users SET profileimg=:profileimg WHERE id=:userid', [':userid' => $userid]);

}
?>
<h1>My Account</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  Upload a profile image:
  <input type="file" name="profileimg"><br><br>
  <input type="submit" name="uploadprofileimg" value="Upload Image">
</form>