<?php
require __DIR__ . '/init.php';

if (Login::isLoggedIn()) {
  $userid = Login::isLoggedIn();
} else {
  die('Not loginIn!');
}

echo '<h1>Notifications</h1>';

if (DB::query('SELECT * FROM notifications WHERE receiver=:userid', [':userid' => $userid])) {
  $notifications = DB::query('SELECT * FROM notifications WHERE receiver=:userid ORDER BY id DESC', [':userid' => $userid]);
  foreach ($notifications as $notification) {
    if ($notification['type'] == 1) {
      $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', [':senderid' => $notification['sender']])[0]['username'];

      if ($notification['extra'] == '') {
        echo'You got notification!<hr><br>';
      } else {
        $extra = json_decode($notification['extra']);
        echo $senderName . ' mentioned you in a post! ' . $extra->postbody . '<hr><br>';
      }


    } else if ($notification['type'] == 2) {
      $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', [':senderid' => $notification['sender']])[0]['username'];
      echo $senderName . ' liked your post!<hr><br>';
    }
  }

}
?>
