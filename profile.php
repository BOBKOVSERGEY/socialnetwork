<?php
require __DIR__ . '/init.php';


$username = '';
$isFollowing = false;
if (isset($_GET['username'])) {
  if (DB::query('SELECT username FROM users WHERE username=:username', [':username' => $_GET['username']])) {
    $username = DB::query('SELECT username FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['username'];
    $userid = DB::query('SELECT id FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['id'];
    $followerid = Login::isLoggedIn();

    if ($userid == $followerid) {
      echo 'Your profile';
    }

    if (isset($_POST['follow'])) {
      if ($userid != $followerid) {
        if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid', [':userid' => $userid])) {
          DB::query('INSERT INTO followers VALUES (null, :userid, :followerid)', ['userid' => $userid, ':followerid' => $followerid]);
        } else {
          echo 'Already following!';
        }
        $isFollowing = true;
      }
    }
    if (isset($_POST['unfollow'])) {
      if ($userid != $followerid) {
        if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid', [':userid' => $userid])) {
          DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', ['userid' => $userid, ':followerid' => $followerid]);
        }
        $isFollowing = false;
      }
    }
    if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid', [':userid' => $userid])) {
      //echo 'Already following!';
      $isFollowing = true;
    }
  } else {
    die('User not found!');
  }
}
?>

<h1><?php echo $username?>'s Profile</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $username; ?>" method="post">
  <?php if ($userid != $followerid) { if ($isFollowing) { ?>
    <input type="submit" name="unfollow" value="Unfollow">
  <?php } else { ?>
    <input type="submit" name="follow" value="Follow">
  <?php } }?>
</form>
