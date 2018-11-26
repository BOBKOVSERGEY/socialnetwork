<?php
require __DIR__ . '/init.php';

if (Login::isLoggedIn()) {
  $userId = Login::isLoggedIn();
} else {
  die('Not loginIn!');
}

if (isset($_POST['send'])) {
  $body = Base::security($_POST['body']);
  $receiver = Base::security($_GET['receiver']);

  if (DB::query('SELECT id FROM users WHERE id=:receiver', [':receiver' => $receiver])) {
    DB::query('INSERT INTO messages VALUES(null, :body, :sender, :receiver, 0)', [':body' => $body, ':sender' => $userId, ':receiver'=> $receiver]);
    echo 'Message sent!';
  } else {
    echo 'Something wrong!';
  }
}

?>
<h1>Send a Message</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>?receiver=<?php echo Base::security($_GET['receiver']); ?>" method="post">
  <textarea name="body" id="" cols="50" rows="10"></textarea><br>
  <input type="submit" name="send" value="Send Message">
</form>