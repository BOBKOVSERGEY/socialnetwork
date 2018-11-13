<?php
require __DIR__ . '/init.php';


$username = '';
$verified = false;
$isFollowing = false;

if (isset($_GET['username'])) {
  if (DB::query('SELECT username FROM users WHERE username=:username', [':username' => $_GET['username']])) {
    $username = DB::query('SELECT username FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['username'];
    $verified = DB::query('SELECT verified FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['verified'];
    $userid = DB::query('SELECT id FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['id'];
    $followerid = Login::isLoggedIn();

    if (isset($_POST['follow'])) {
      if ($userid != $followerid) {
        if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', [':userid' => $userid, ':followerid' => $followerid])) {
          if ($followerid == 14) {
            DB::query('UPDATE users SET verified=1 WHERE id=:userid', [':userid' => $userid]);
          }
          DB::query('INSERT INTO followers VALUES (null, :userid, :followerid)', ['userid' => $userid, ':followerid' => $followerid]);
        } else {
          echo 'Already following!';
        }
        $isFollowing = true;
      }
    }
    if (isset($_POST['unfollow'])) {
      if ($userid != $followerid) {
        if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', [':userid' => $userid, ':followerid' => $followerid])) {
          if ($followerid == 14) {
            DB::query('UPDATE users SET verified=0 WHERE id=:userid', [':userid' => $userid]);
          }
          DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', ['userid' => $userid, ':followerid' => $followerid]);
        }
        $isFollowing = false;
      }
    }
    if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', [':userid' => $userid, ':followerid' => $followerid])) {
      $isFollowing = true;
    }

    if (isset($_POST['post'])) {
      $postbody = Base::security($_POST['postbody']);
      $userid = Login::isLoggedIn();

      if (strlen($postbody) > 160 || strlen($postbody) < 1) {
        die('Incorrect length!');
      }

      DB::query('INSERT INTO posts VALUES(null, :postbody, NOW(), :userid, 0)', [':postbody' => $postbody, ':userid' => $userid]);
    }

    $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', [':userid' => $userid]);

    $posts = '';
    foreach ($dbposts as $p) {
      $posts .= $p['body']. '<hr><br>';
    }

  } else {
    die('User not found!');
  }
}

?>


<h1><?php echo $username?>'s Profile<?php if ($verified) echo '-Verified'; ?></h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $username; ?>" method="post">
  <?php if ($userid != $followerid) { if ($isFollowing) { ?>
    <input type="submit" name="unfollow" value="Unfollow">
  <?php } else { ?>
    <input type="submit" name="follow" value="Follow">
  <?php } }?>
</form>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $username; ?>" method="post">
  <textarea name="postbody" id="" cols="30" rows="10"></textarea><br>
  <input type="submit" name="post" value="Post">
</form>

<div class="posts">
  <?php echo $posts; ?>
</div>
