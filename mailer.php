<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

// Create a new instance of PHPMailer
$mail = new PHPMailer(true);

// Enable verbose debugging
$mail->SMTPDebug = SMTP::DEBUG_OFF;

// Set SMTP configuration
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "kipmike18@gmail.com";
$mail->Password = "opbaujkuhxxbcnqv";

// Set email content
$mail->isHtml(true);

return $mail;
?>