<?php
require __DIR__ . '/init.php';

if (Login::isLoggedIn()) {
  $userId = Login::isLoggedIn();
} else {
  die('Not loginIn!');
}

if (isset($_GET['mid'])) {
  $mid = Base::security($_GET['mid']);
  $message = DB::query('SELECT * FROM messages WHERE id=:mid AND (receiver=:receiver OR sender=:sender)', [':mid' => $mid, ':receiver' => $userId, ':sender' => $userId])[0];
  echo '<h1>View message</h1><br>';
  echo $message['body'];

  if ($message['sender'] == $userId) {
    $id = $message['receiver'];
  } else {
    $id = $message['sender'];
  }

  DB::query('UPDATE messages SET watched=1 WHERE id=:mid', [':mid'=>$mid]);

  ?>
  <form action="send-message.php?receiver=<?php echo $id; ?>" method="post">
    <textarea name="body" id="" cols="50" rows="10"></textarea><br>
    <input type="submit" name="send" value="Send Message">
  </form>
  <?php
} else {
  ?>
  <h1>My messages</h1>
  <?php
  $messages = DB::query('SELECT messages.*, users.username FROM messages, users WHERE (receiver=:receiver OR sender=:sender) AND users.id = messages.sender', [':receiver' => $userId, ':sender' => $userId]);
//$messages = DB::query('SELECT messages.*, users.username FROM messages, users WHERE receiver=:receiver AND users.id = messages.sender', [':receiver' => $userId]);
  foreach ($messages as $message) {

    if (strlen($message['body']) > 10) {
      $msg = substr($message['body'], 0, 10) . "...";
    } else {
      $msg = $message['body'];
    }

    if ($message['watched'] == 0) {
      echo "<a href='my-messages.php?mid=" . $message['id'] . "'><strong>" . $msg. '</strong></a> sent by ' . $message['username'] . '<br><hr>';
    } else {
      echo "<a href='my-messages.php?mid=" . $message['id'] . "'>" . $msg . '</a> sent by ' . $message['username'] . '<br><hr>';
    }
  }
  ?>
  <?php
}

?>
