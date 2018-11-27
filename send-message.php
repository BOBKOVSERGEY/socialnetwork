<?php
require __DIR__ . '/init.php';


$cstrong = True;
$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

if (!isset($_SESSION['token'])) {
  $_SESSION['token'] = $token;
}



if (Login::isLoggedIn()) {
  $userId = Login::isLoggedIn();
} else {
  die('Not loginIn!');
}

if (isset($_POST['send'])) {

  $body = Base::security($_POST['body']);
  $receiver = Base::security($_GET['receiver']);

  if (!isset($_POST['nocsrf'])) {
    die('Invalid token!');
  }

  if ($_POST['nocsrf'] != $_SESSION['token']) {
    die('Invalid token!');
  }

  if (strlen($body) < 1) {
    die('Incorrect length!');
  }
  if (DB::query('SELECT id FROM users WHERE id=:receiver', [':receiver' => $receiver])) {
    DB::query('INSERT INTO messages VALUES(null, :body, :sender, :receiver, 0)', [':body' => $body, ':sender' => $userId, ':receiver'=> $receiver]);
    echo 'Message sent!';
  } else {
    echo 'Something wrong!';
  }

  session_destroy();
}

?>
<h1>Send a Message</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>?receiver=<?php if (isset($_GET['receiver'])) echo Base::security($_GET['receiver']); ?>" method="post">
  <textarea name="body" id="" cols="50" rows="10"></textarea><br>
  <input type="hidden" name="nocsrf" value="<?php echo $_SESSION['token']?>">
  <input type="submit" name="send" value="Send Message">
</form>