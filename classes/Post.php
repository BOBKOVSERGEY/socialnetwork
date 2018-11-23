<?php

class Post
{
  public static function createPost($postbody, $loggedInUserId, $profileUserId)
  {
    if (strlen($postbody) > 160 || strlen($postbody) < 1) {
      die('Incorrect length!');
    }

    $topics = self::getTopics($postbody);

    if ($loggedInUserId == $profileUserId) {

      if (count(Notify::createNotify($postbody)) != 0) {
        foreach (Notify::createNotify($postbody) as $key => $n) {
          $s = $loggedInUserId;
          $r = DB::query('SELECT id FROM users WHERE username=:username', [':username' => $key])[0]['id'];

          if ($r != 0) {
            DB::query('INSERT INTO notifications VALUES (null, :type, :receiver, :sender, :extra)', [':type' => $n['type'], ':receiver' => $r, ':sender' => $s, ':extra'=>$n['extra']]);
          }

        }
      }

      DB::query('INSERT INTO posts VALUES(null, :postbody, NOW(), :userid, 0, null, :topics)', [':postbody' => $postbody, ':userid' => $profileUserId, ':topics'=>$topics]);
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

    $topics = self::getTopics($postbody);

    if ($loggedInUserId == $profileUserId) {

      if (count(Notify::createNotify($postbody)) != 0) {
        foreach (Notify::createNotify($postbody) as $key => $n) {
          $s = $loggedInUserId;
          $r = DB::query('SELECT id FROM users WHERE username=:username', [':username' => $key])[0]['id'];

          if ($r != 0) {
            DB::query('INSERT INTO notifications VALUES (null, :type, :receiver, :sender, :extra)', [':type' => $n['type'], ':receiver' => $r, ':sender' => $s, ':extra'=>$n['extra']]);
          }

        }
      }

      DB::query('INSERT INTO posts VALUES(null, :postbody, NOW(), :userid, 0, null, :topics)', [':postbody' => $postbody, ':userid' => $profileUserId, ':topics'=>$topics]);
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
      Notify::createNotify('', $postid);
      //header("Location: profile.php?username=$username");
    } else {
      DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid', [':postid' => $postid]);
      DB::query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $postid, ':userid' => $likerId]);
      //header("Location: profile.php?username=$username");

    }
  }

  public static function getTopics($text) {
    $text = explode(" ", $text);
    $topics = "";
    foreach ($text as $word) {
      if (substr($word, 0, 1) == "#") {
        $topics .= substr($word, 1).",";
      }
    }
    return $topics;
  }

  public static function linkAdd($text)
  {
    $text = explode(' ', $text);
    $newstring = '';
    foreach ($text as $word) {
      if (substr($word, 0, 1) == '@') {
        $newstring .= "<a href='profile.php?username=" . substr($word, 1) . "'>" . $word . '</a> ';
      } else if (substr($word, 0, 1) == '#') {
        $newstring .= "<a href='topics.php?topic=" . substr($word, 1) . "'>" . $word . '</a> ';
      } else {
        $newstring .= $word . ' ';
      }
    }
    return $newstring;
  }

  public static function displayPosts($userid, $username, $loggedInUserId)
  {
    $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', [':userid' => $userid]);

    $posts = '';
    foreach ($dbposts as $p) {

      if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $p['id'], ':userid'=>$loggedInUserId])) {
        if (!empty($p['postimg'])){
          $posts .= "<img src=" . $p['postimg'] ."><br>". self::linkAdd($p['body'])."
          <form action='$_SERVER[PHP_SELF]?username=$username&postid=" . $p['id'] ."' method='post'>
            <input type='submit' name='like' value='Like'>
            <span>".$p['likes']." likes</span>";

          if ($userid == $loggedInUserId) {
            $posts .= " <input type='submit' name='deletepost' value='&times;'>";
          }

          $posts .="</form><hr><br>";
        } else {
          $posts .= self::linkAdd($p['body'])."
          <form action='$_SERVER[PHP_SELF]?username=$username&postid=" . $p['id'] ."' method='post'>
            <input type='submit' name='like' value='Like'>
            <span>".$p['likes']." likes</span>";

          if ($userid == $loggedInUserId) {
            $posts .= " <input type='submit' name='deletepost' value='&times;'>";
          }

          $posts .= "</form><hr><br>";
        }

      } else {
        if (!empty($p['postimg'])){
          $posts .= "<img src=" . $p['postimg'] ."><br>" . self::linkAdd($p['body'])."
          <form action='$_SERVER[PHP_SELF]?username=$username&postid=" . $p['id'] ."' method='post'>
            <input type='submit' name='unlike' value='Unlike'>
            <span>".$p['likes']." likes</span>";

          if ($userid == $loggedInUserId) {
            $posts .= " <input type='submit' name='deletepost' value='&times;'>";
          }

          $posts .= "</form><hr><br>";
        } else {
          $posts .= self::linkAdd($p['body'])."
          <form action='$_SERVER[PHP_SELF]?username=$username&postid=" . $p['id'] ."' method='post'>
            <input type='submit' name='unlike' value='Unlike'>
            <span>".$p['likes']." likes</span>";

          if ($userid == $loggedInUserId) {
            $posts .= " <input type='submit' name='deletepost' value='&times;'>";
          }

          $posts .= "</form><hr><br>";
        }

      }

    }
    return $posts;
  }

}