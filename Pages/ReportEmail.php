<?php
require_once('class.phpmailer.php');
require_once('PHPMailerAutoload.php');

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->Username = userEmail;
$mail->Password = 'password';
$mail->SMTPAuth = true;

$mail->From = 'username@gmail.com'; // Sender email
$mail->FromName = 'title';
$mail->AddAddress('username@gmail.com');

$mail->IsHTML(true);
$mail->Subject    = "PHPMailer Test Subject via Sendmail, basic";
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->Body    = "Your question is reported as it has ";

$mail->SMTPDebug  = 1;            
if(!$mail->Send())
{
  echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
  echo "Message sent!";
}
?>