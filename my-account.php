<?php
require __DIR__ . '/init.php';

if (Login::isLoggedIn()) {
  $userid = Login::isLoggedIn();
} else {
  die('Not logged in!');
}

if (isset($_POST['uploadprofileimg'])) {

  $image = base64_encode(file_get_contents($_FILES['profileimg']['tmp_name']));

  $options = [
    'http' => [
      'method' => 'POST',
      'header' => "Authorization: Bearer 095e93944f5858ea880932be350d9aa8f958ce7b\n".
        "Content-type: application/x-www-form-urlencoded",
      'content' => $image
    ]
  ];

  $context = stream_context_create($options);

  $imgurURL = 'https://api.imgur.com/3/image';

  if ($_FILES['profileimg']['size'] > 10240000) {
    die('Image to big, must be 10MB or less!');
  }

  $response = file_get_contents($imgurURL, false, $context);

  $response = json_decode($response);

  debug($response);
  DB::query('UPDATE users SET profileimg=:profileimg WHERE id=:userid', [':profileimg' => $response->data->link, ':userid' => $userid]);

}
?>
<h1>My Account</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  Upload a profile image:
  <input type="file" name="profileimg"><br><br>
  <input type="submit" name="uploadprofileimg" value="Upload Image">
</form>