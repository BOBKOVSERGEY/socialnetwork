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
      $loggedInUserId = Login::isLoggedIn();

      if (strlen($postbody) > 160 || strlen($postbody) < 1) {
        die('Incorrect length!');
      }
      if ($loggedInUserId == $userid) {
        DB::query('INSERT INTO posts VALUES(null, :postbody, NOW(), :userid, 0)', [':postbody' => $postbody, ':userid' => $userid]);
      } else {
        die('Incorrect user');
      }
    }

    if (isset($_GET['postid'])) {
      if (!DB::query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $_GET['postid'], ':userid' => $followerid])) {
        DB::query('UPDATE posts SET likes=likes+1 WHERE id=:postid', [':postid' => $_GET['postid']]);
        DB::query('INSERT INTO post_likes VALUES (null, :postid, :userid)', [':postid' => $_GET['postid'], ':userid' => $followerid]);
        header("Location: profile.php?username=$username");
      } else {
        DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid', [':postid' => $_GET['postid']]);
        DB::query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $_GET['postid'], ':userid' => $followerid]);
        header("Location: profile.php?username=$username");
      }
    }

    $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', [':userid' => $userid]);

    $posts = '';
    foreach ($dbposts as $p) {

      if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $p['id'], ':userid'=>$followerid])) {
        $posts .= $p['body']."
      <form action='$_SERVER[PHP_SELF]?username=$username&postid=" . $p['id'] ."' method='post'>
    <input type='submit' name='like' value='Like'>
    <span>".$p['likes']." likes</span>
     </form><hr><br>";
      } else {
        $posts .= $p['body']."
      <form action='$_SERVER[PHP_SELF]?username=$username&postid=" . $p['id'] ."' method='post'>
    <input type='submit' name='unlike' value='Unlike'>
    <span>".$p['likes']." likes</span>
     </form><hr><br>";
      }

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
