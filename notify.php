<?php
require __DIR__ . '/init.php';

if (Login::isLoggedIn()) {
  $userid = Login::isLoggedIn();
} else {
  echo 'Not loginIn!';
}

if (DB::query('SELECT * FROM notifications WHERE receiver=:userid', [':userid' => $userid])) {
  $notifications = DB::query('SELECT * FROM notifications WHERE receiver=:userid', [':userid' => $userid]);
  debug($notifications);
  foreach ($notifications as $notification) {
    echo $notification['type'] . '<br>';
  }

}
?>
