<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/../init.php';

$db = new DB("localhost", "SocialNetwork", "root", "");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if ($_GET['url'] == "auth") {
  } else if ($_GET['url'] == "search") {
    $tosearch = explode(' ', $_GET['query']);
    if (count($tosearch) == 1) {
      $tosearch = str_split($tosearch[0], 2);
    }
    $whereclause = '';
    $paramsArray = [':body' => '%'.$_GET['query'].'%'];

    for ($i = 0; $i < count($tosearch); $i++) {
      if ($i % 2) {
        $whereclause .= " OR body LIKE :p$i";
        $paramsArray[":p$i"] = $tosearch[$i];
      }
    }
    $posts = $db->query('SELECT posts.body, users.username, posts.posted_at FROM posts, users WHERE users.id = posts.user_id AND posts.body LIKE :body ' . $whereclause . ' LIMIT 10', $paramsArray);
    echo json_encode($posts);

  } else if ($_GET['url'] == "users") {
  } else if ($_GET['url'] == "comments" && isset($_GET['postid'])) {

    if ($db->query('SELECT comments.comment, comments.posted_at, users.username FROM comments, users WHERE post_id=:postid AND comments.user_id = users.id', [':postid' => $_GET['postid']])) {
      $output = '';
      $comments = $db->query('SELECT comments.comment, comments.posted_at, users.username FROM comments, users WHERE post_id=:postid AND comments.user_id = users.id', [':postid' => $_GET['postid']]);
      $output .= "[";
      foreach($comments as $comment) {
        $output .= "{";
        $output .= '"Comment": "'.$comment['comment'].'",';
        $output .= '"CommentedBy": "'.$comment['username'].'"';
        $output .= "},";
        //echo $comment['comment']." ~ ".$comment['username']."<hr />";
      }
      $output = substr($output, 0, strlen($output)-1);
      $output .= "]";
      echo $output;
    }

  } else if ($_GET['url'] == "posts") {
    $token = $_COOKIE['SNID'];
    $userid = $db->query('SELECT user_id FROM login_tokens WHERE token=:token', [':token' => sha1($token)])[0]['user_id'];

    $followingposts = $db->query('SELECT posts.postimg,posts.posted_at,posts.id, posts.body, posts.likes, users.`username` FROM users, posts, followers
                                  WHERE posts.user_id = followers.user_id
                                  AND users.id = posts.user_id
                                  AND follower_id = :userid
                                  ORDER BY posts.likes DESC;', [':userid' => $userid]);

    if (!empty($followingposts)) {
      $response = '[';
      foreach ($followingposts as $post) {

        $response .= '{';
        $response .= '"PostId": ' .$post['id'].',';
        $response .= '"PostBody": "' .$post['body'].'",';
        $response .= '"PostedBy": "' .$post['username'].'",';
        $response .= '"PostImg": "' .$post['postimg'].'",';
        $response .= '"PostDate": "' .$post['posted_at'].'",';
        $response .= '"Likes": ' .$post['likes'].'';
        $response .= '},';

      }
      $response = substr($response, 0, strlen($response) - 1);
      $response .= ']';

      http_response_code(200);
      echo $response;
    } else {
      echo 'There no posts!';
    }
  } else if ($_GET['url'] == "profileposts") {
    $userid = $db->query('SELECT id FROM users WHERE username=:username', [':username' => $_GET['username']])[0]['id'];

    $followingposts = $db->query('SELECT posts.postimg,posts.posted_at,posts.id, posts.body, posts.likes, users.`username` FROM users, posts
    WHERE users.id = posts.user_id
    AND users.id = :userid
    ORDER BY posts.id DESC;', [':userid' => $userid]);

    if (!empty($followingposts)) {
      $response = '[';
      foreach ($followingposts as $post) {

        $response .= '{';
        $response .= '"PostId": ' .$post['id'].',';
        $response .= '"PostBody": "' .$post['body'].'",';
        $response .= '"PostedBy": "' .$post['username'].'",';
        $response .= '"PostImg": "' .$post['postimg'].'",';
        $response .= '"PostDate": "' .$post['posted_at'].'",';
        $response .= '"Likes": ' .$post['likes'].'';
        $response .= '},';

      }
      $response = substr($response, 0, strlen($response) - 1);
      $response .= ']';

      http_response_code(200);
      echo $response;
    } else {
      echo 'There no posts!';
    }
  }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if ($_GET['url'] == 'users') {
    $postBody = file_get_contents("php://input");
    $postBody = json_decode($postBody);
    $username = $postBody->username;
    $email = $postBody->email;
    $password = $postBody->password;

    if (!$db->query('SELECT username FROM users WHERE username=:username', [':username' => $username])) {
      if (strlen($username) >= 3 && strlen($username) <= 32) {
        if (!preg_match('/[^A-Za-z0-9]/', $username)) {
          if (strlen($password) >= 6 && strlen($password) <= 60) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
              if (!$db->query('SELECT email FROM users WHERE email=:email', [':email' => $email])) {
                $db->query('INSERT INTO users VALUES (null, :username, :password, :email, \'0\', null)', [':username' => $username, ':password' => password_hash($password, PASSWORD_BCRYPT), ':email' => $email]);

                Mail::sendMail('Welcome to our Social Network!', 'Your account has been created!', $email);

                echo '{ "Success": "User created!" }';
                http_response_code(200);
              } else {
                echo '{ "Error": "Invalid username!" }';
                http_response_code(409);
              }
            } else {
              echo '{ "Error": "Email in use!" }';
              http_response_code(409);
            }
          } else {
            echo '{ "Error": "Invalid password!" }';
            http_response_code(409);
          }
        } else {
          echo '{ "Error": "Invalid username!" }';
          http_response_code(409);
        }
      } else {
        echo '{ "Error": "Invalid username!" }';
        http_response_code(409);
      }
    } else {
      echo '{ "Error": "User exists!" }';
      http_response_code(409);
    }

  }

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
  } else if ($_GET['url'] == 'likes') {
    $postId = $_GET['id'];
    $token = $_COOKIE['SNID'];

    $likerId = $db->query('SELECT user_id FROM login_tokens WHERE token=:token', [':token' => sha1($token)])[0]['user_id'];

    if (!$db->query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $postId, ':userid' => $likerId])) {
      $db->query('UPDATE posts SET likes=likes+1 WHERE id=:postid', [':postid' => $postId]);
      $db->query('INSERT INTO post_likes VALUES (null, :postid, :userid)', [':postid' => $postId, ':userid' => $likerId]);
      //Notify::createNotify('', $postId);
      //header("Location: profile.php?username=$username");
    } else {
      $db->query('UPDATE posts SET likes=likes-1 WHERE id=:postid', [':postid' => $postId]);
      $db->query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', [':postid' => $postId, ':userid' => $likerId]);
      //header("Location: profile.php?username=$username");

    }

    echo "{";
    echo '"Likes":';
    echo $db->query('SELECT likes FROM posts WHERE id=:postid', [':postid' => $postId])[0]['likes'];
    echo "}";

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