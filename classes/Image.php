<?php

class Image
{
  public static function uploadImage($formname, $query, $params)
  {
    $image = base64_encode(file_get_contents($_FILES[$formname]['tmp_name']));

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

    if ($_FILES[$formname]['size'] > 10240000) {
      die('Image to big, must be 10MB or less!');
    }

    $response = file_get_contents($imgurURL, false, $context);

    $response = json_decode($response);

    $preparams = [$formname => $response->data->link];
    $params = $preparams + $params;

    //debug($response);
    DB::query($query, $params);
  }
}