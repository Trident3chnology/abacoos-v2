<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Create a new PHPMailer object
$mail = new PHPMailer(true);

// Server settings
$mail->SMTPDebug = 0; // Disable verbose debug output
$mail->isSMTP(); // Send using SMTP
$mail->Host = 'smtp.hostinger.com'; // Set the SMTP server to send through
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'noreply@trident3chnology.com'; // SMTP username
$mail->Password = '@Gamechanger2025'; // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
$mail->Port = 587; // TCP port to connect to

// Recipients
$mail->setFrom('noreply@trident3chnology.com', 'Abacoos');
$mail->addReplyTo('info@tridentechnology.com', 'Customer Support');
$mail->addAddress($email);

// Content
$mail->isHTML(true);
$mail->Subject = 'Abacoos Registration Attempt Alert';
$mail->Body = '
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #e0e5ec;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
      max-width: 480px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 1.55rem !important;
      background: #e0e5ec;
      box-shadow: 8px 8px 16px #b8bec7,
        -8px -8px 16px #ffffff;
      text-align: center;
    }

    .logo {
      width: 80px;
      margin-bottom: 20px;
    }

    h1 {
      margin: 0;
      font-size: 24px;
      color: #333;
    }

    p {
      color: #555;
      font-size: 14px;
      margin: 15px 0;
    }

    .alert-box {
      margin: 25px 0;
      padding: 15px;
      font-size: 16px;
      font-weight: bold;
      color: #00b894;
      border-radius: 15px;
      background: #e0e5ec;
      box-shadow: inset 6px 6px 10px #b8bec7,
        inset -6px -6px 10px #ffffff;
    }

    .btn {
      display: inline-block;
      padding: 12px 25px;
      border-radius: 30px;
      text-decoration: none;
      font-size: 14px;
      color: #333;
      background: #e0e5ec;
      box-shadow: 5px 5px 10px #b8bec7,
        -5px -5px 10px #ffffff;
      transition: all 0.3s ease;
    }

    .btn:hover {
      box-shadow: inset 5px 5px 10px #b8bec7,
        inset -5px -5px 10px #ffffff;
    }

    .footer {
      margin-top: 25px;
      font-size: 12px;
      color: #888;
    }

    @media screen and (max-width: 500px) {
      .container {
        margin: 20px;
        padding: 20px;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <img src="https://via.placeholder.com/80" alt="Logo" class="logo">

    <h1>Registration Attempt Alert</h1>

    <p>Hi there ' . $stmtFirstName . ',<br>
      We noticed a new registration attempt on your account email.</p>

    <div class="alert-box">
      Attempted at: ' . $today_date1 . ' <br>
      Channel: ' . $browser . ' <br>
      Device/IP Address: ' . $device . ' ' . $os . '/' . $_SERVER['REMOTE_ADDR'] . '
    </div>

    <a href="#" class="btn">Review Registration</a>

    <p>If this was you, you can safely ignore this message. Otherwise, click the button above to secure your account.
    </p>

    <div class="footer">
      &copy; 2026 Trident3chnology. All rights reserved.
    </div>
  </div>

</body>

</html>
';

$mail->addCustomHeader('X-Mailer', 'PHP/' . phpversion());
$mail->addCustomHeader('X-Originating-IP', $_SERVER['SERVER_ADDR']);
$mail->send();
?>