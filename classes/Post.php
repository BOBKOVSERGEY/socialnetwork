<?php

class Post
{
  public static function createPost($postbody, $loggedInUserId, $profileUserId)
  {
    if (strlen($postbody) > 160 || strlen($postbody) < 1) {
      die('Incorrect length!');
    }
    if ($loggedInUserId == $profileUserId) {
      DB::query('INSERT INTO posts VALUES(null, :postbody, NOW(), :userid, 0, null)', [':postbody' => $postbody, ':userid' => $profileUserId]);
      //header("Location: profile.php?username=$username");
    } else {
      die('Incorrect user');
    }
  }

  public static function createImgPost($postbody, $loggedInUserId, $profileUserId)
  {
    if (strlen($postbody) > 160) {
      die('Incorrect length!');
    }
    if ($loggedInUserId == $profileUserId) {
      DB::query('INSERT INTO posts VALUES(null, :postbody, NOW(), :userid, 0, null)', [':postbody' => $postbody, ':userid' => $profileUserId]);
      $postid = DB::query('SELECT id FROM posts WHERE user_id=:userid ORDER BY id DESC LIMIT 1', [':userid'=> $loggedInUserId])[0]['id'];
      return $postid;
    } else {
      die('Incorrect user');
    }
  }

  public static function likePost($postid, $likerId)
  {
    if (!DB::query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $postid, ':userid' => $likerId])) {
      DB::query('UPDATE posts SET likes=likes+1 WHERE id=:postid', [':postid' => $postid]);
      DB::query('INSERT INTO post_likes VALUES (null, :postid, :userid)', [':postid' => $postid, ':userid' => $likerId]);
      //header("Location: profile.php?username=$username");
    } else {
      DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid', [':postid' => $postid]);
      DB::query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $postid, ':userid' => $likerId]);
      //header("Location: profile.php?username=$username");

    }
  }

  public static function displayPosts($userid, $username, $loggedInUserId)
  {
    $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', [':userid' => $userid]);

    $posts = '';
    foreach ($dbposts as $p) {

      if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $p['id'], ':userid'=>$loggedInUserId])) {
        $posts .= "<img src=" . $p['postimg'] ."><br>". $p['body']."
      <form action='$_SERVER[PHP_SELF]?username=$username&postid=" . $p['id'] ."' method='post'>
    <input type='submit' name='like' value='Like'>
    <span>".$p['likes']." likes</span>
     </form><hr><br>";
      } else {
        $posts .= "<img src=" . $p['postimg'] ."><br>" . $p['body']."
      <form action='$_SERVER[PHP_SELF]?username=$username&postid=" . $p['id'] ."' method='post'>
    <input type='submit' name='unlike' value='Unlike'>
    <span>".$p['likes']." likes</span>
     </form><hr><br>";
      }

    }
    return $posts;
  }

}