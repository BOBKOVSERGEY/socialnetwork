<?php
session_start();
error_reporting(-1);
// только php mailer
//require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register(function($className) {
  require __DIR__ . '/classes/' . $className . '.php';
});

function debug($array)
{
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}

function debugVarDump($array)
{
  echo '<pre>';
  var_dump($array);
  echo '</pre>';
}

function redirect($http = false)
{
  if ($http) {
    $redirect = $http;
  } else {
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
  }

  header("Location: $redirect");
  exit;
}