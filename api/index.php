<?php
require_once __DIR__ . '/DB.php';

$db = new DB("localhost", "SocialNetwork", "root", "");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if ($_GET['url'] == "auth") {
  } else if ($_GET['url'] == "users") {
  }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if ($_GET['url'] == "auth") {
    $postBody = file_get_contents("php://input");
    $postBody = json_decode($postBody);
    $username = $postBody->username;
    $password = $postBody->password;
    if ($db->query('SELECT username FROM users WHERE username=:username', [':username'=>$username])) {
      if (password_verify($password, $db->query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
        $cstrong = True;
        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        $user_id = $db->query('SELECT id FROM users WHERE username=:username', [':username'=>$username])[0]['id'];
        $db->query('INSERT INTO login_tokens VALUES (null, :token, :user_id)', [':token'=>sha1($token), ':user_id'=>$user_id]);
        echo '{ "Token": "'.$token.'" }';
      } else {
        echo '{ "Error": "Invalid username or password!" }';
        http_response_code(401);
      }
    } else {
      echo '{ "Error": "Invalid username or password!" }';
      http_response_code(401);
    }
  }
}  else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
  if ($_GET['url'] == "auth") {
    if (isset($_GET['token'])) {
      if ($db->query("SELECT token FROM login_tokens WHERE token=:token", [':token'=>sha1($_GET['token'])])) {
        $db->query('DELETE FROM login_tokens WHERE token=:token', [':token'=>sha1($_GET['token'])]);
        echo '{ "Status": "Success" }';
        http_response_code(200);
      } else {
        echo '{ "Error": "Invalid token" }';
        http_response_code(400);
      }
    } else {
      echo '{ "Error": "Malformed request" }';
      http_response_code(400);
    }
  }
} else {
  http_response_code(405);
}
?>