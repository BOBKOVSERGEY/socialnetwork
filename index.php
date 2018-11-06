<?php
require __DIR__ . '/init.php';



if (Login::isLoggedIn()) {
  echo 'Logged In';
  echo '<br>';
  echo Login::isLoggedIn();
} else {
  echo 'No login';
}