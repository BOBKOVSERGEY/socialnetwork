<?php
require __DIR__ . '/init.php';

if (isset($_GET['topic'])) {
  if (DB::query('SELECT topics FROM posts WHERE FIND_IN_SET(:topic, topics)',[':topic'=> $_GET['topic']])) {
    $posts = DB::query('SELECT * FROM posts WHERE FIND_IN_SET(:topic, topics)',[':topic'=> $_GET['topic']]);
    //debug($posts);
    foreach ($posts as $post) {
      echo $post['body'] . '<br>';
    }

  } else {
    echo 'INValid topic';
  }
}