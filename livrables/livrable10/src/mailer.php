<?php
/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . "/vendor/autoload.php";

//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.example.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "findercinenoreply@gmail.com";
$mail->Password = "Sae1234567";

$mail->isHtml(true);

return $mail;
*/
 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
 
//Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
 
    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'findercinenoreply@gmail.com';   //SMTP write your email
    $mail->Password   = 'gkdjtypgeddacomm';      //SMTP password
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;                                    
    return $mail;
    /*
    //Recipients
    //$mail->setFrom( $_POST["email"], $_POST["name"]); // Sender Email and name
    $mail->addAddress('salu27oki@gmail.com');     //Add a recipient email  
    //$mail->addReplyTo($_POST["email"], $_POST["name"]); // reply to sender email
 
    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = $_POST["subject"];   // email subject headings
    $mail->Body    = $_POST["message"]; //email message
      
    // Success sent message alert
    $mail->send();
    */