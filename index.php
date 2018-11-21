<?php
require __DIR__ . '/init.php';

$showTimeline = false;

if (Login::isLoggedIn()) {
  $userid = Login::isLoggedIn();
  $showTimeline = true;

  if (isset($_GET['postid'])) {
    Post::likePost($_GET['postid'], $userid);
  }

  if (isset($_POST['comment'])) {
    Comment::createComment(Base::security($_POST['commentbody']), $_GET['commentpostid'], $userid);
  }

  $followingposts = DB::query('SELECT posts.postimg, posts.id, posts.body, posts.likes, users.`username` FROM users, posts, followers
WHERE posts.user_id = followers.user_id
AND users.id = posts.user_id
AND follower_id = :userid
ORDER BY posts.likes DESC;', [':userid' => $userid]);

  if (!empty($followingposts)) {
    foreach ($followingposts as $post) {
      echo $post['postimg'] . '<br>' .$post['body'] . ' ~ ' . $post['username'] . '<br>';
      echo "<form action='$_SERVER[PHP_SELF]?postid=" . $post['id'] ."' method='post'>";

      if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $post['id'], ':userid'=>$userid])) {
        echo "<input type='submit' name='like' value='Like'>";
      } else {
        echo "<input type='submit' name='unlike' value='Unlike'>";
      }
      echo "<span>".$post['likes']." likes</span>
          </form>
          <form action='$_SERVER[PHP_SELF]?commentpostid=".$post['id']."' method='post'>
            <textarea name='commentbody' cols='50' rows='3'></textarea><br>
            <input type='submit' name='comment' value='Comment'>
          </form>";

      Comment::displayComments($post['id']);

      echo "<hr><br>";

    }
  } else {
    echo 'There no posts!';
  }


} else {
  echo 'No login';
}
