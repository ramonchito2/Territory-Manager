<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

$mail = new PHPMailer(true);
try {
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail-> SMTPSecure = 'ssl';
	$mail->SMTPDebug = 2;
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->isHTML(true);
	$mail->Username = 'khprograms.site@gmail.com';
	$mail->Password = GM_PASS;
	$mail->SetFrom('khprograms@gmail.com');
	$mail->Subject = 'Hello This is a Test';
	$mail->Body = 'Yes it is.. this is a test email send by moi';
	$mail->AddAddress('jirrodglynn@gmail.com');
	$mail->Send();
	echo "Message has been sent";
} catch (Exception $e) {
	echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}