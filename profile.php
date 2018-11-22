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

    if (isset($_POST['deletepost'])) {
      if (DB::query('SELECT id FROM posts WHERE id=:postid AND user_id=:userid', [':postid' => $_GET['postid'], ':userid' => $followerid])) {
        DB::query('DELETE FROM posts WHERE id=:postid AND user_id=:userid',[':postid'=> $_GET['postid'], ':userid' => $followerid]);
        DB::query('DELETE FROM post_likes WHERE post_id=:postid',[':postid'=> $_GET['postid']]);
        echo 'Post deleted';
      } else {
        echo 'Something wrong!';
      }
    }

    if (isset($_POST['post'])) {
      if ($_FILES['postimg']['size'] == 0) {
        Post::createPost(Base::security($_POST['postbody']), Login::isLoggedIn(), $userid);
      } else {
        $postid = Post::createImgPost(Base::security($_POST['postbody']), Login::isLoggedIn(), $userid);
        Image::uploadImage('postimg','UPDATE posts SET postimg=:postimg WHERE id=:postid', [':postid'=> $postid]);
      }
    }

    if (isset($_GET['postid']) && !isset($_POST['deletepost'])) {
      Post::likePost($_GET['postid'], $followerid);
    }

    $posts = Post::displayPosts($userid, $username, $followerid);

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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?username=<?php echo $username; ?>" method="post" enctype="multipart/form-data">
  <textarea name="postbody" id="" cols="50" rows="10"></textarea><br>
  Upload an image:
  <input type="file" name="postimg"><br><br>
  <input type="submit" name="post" value="Post">
</form>

<div class="posts">
  <?php echo $posts; ?>
</div>
