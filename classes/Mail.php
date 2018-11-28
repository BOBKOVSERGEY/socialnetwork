<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
  public static function sendMail($subject, $body, $address) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML(true);
    $mail->Username = 'socnetsb@gmail.com';
    $mail->Password = '1987Kira1954';
    $mail->setFrom('socnetsb@gmail.com', 'SocialNetwork');
    $mail->Subject = $subject;
    $mail->CharSet = 'UTF-8';
    $mail->Body = $body;
    $mail->AddAddress($address);
    $mail->send();
  }
}

