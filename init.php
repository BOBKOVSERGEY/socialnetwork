<?php
session_start();
error_reporting(-1);
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