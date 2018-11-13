<?php

class Base
{
  public static function security($data)
  {
    return trim(strip_tags($data));
  }
}