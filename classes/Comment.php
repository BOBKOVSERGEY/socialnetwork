<?php

class Comment
{
  public static function createComment($commentBody, $postId, $userId)
  {
    if (strlen($commentBody) > 160 || strlen($commentBody) < 1) {
      die('Incorrect length!');
    }

    if (!DB::query('SELECT id FROM posts WHERE id=:postid', [':postid' => $postId])) {
      echo 'Invalid post Id';
    } else {
      DB::query('INSERT INTO comments VALUES (null, :comment, :userid, NOW(), :postid)', [':comment' => $commentBody, ':userid' => $userId, ':postid' => $postId]);
      redirect('/');
    }

  }

  public static function displayComments($postId)
  {
    $comments = DB::query('SELECT comments.comment, comments.posted_at, users.username FROM comments, users WHERE post_id=:postid AND comments.user_id = users.id', [':postid' => $postId]);
    //debug($comments);
    foreach ($comments as $comment) {
      echo 'Comments ~' . $comment['username'] . ' ' . $comment['posted_at'] . '<br>' . $comment['comment']. '<br><hr>';
    }

  }
}