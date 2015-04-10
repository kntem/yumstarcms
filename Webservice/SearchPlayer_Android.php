<?php

include 'class.phpmailer.php';
include 'class.smtp.php';


//SEnd Email
$mail = new PHPMailer();  // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->IsHTML(true);
$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true;  // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "smtp.gmail.com";
//$mail->Port = 465;

//   $mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->Username = "demo.narolainfotech@gmail.com";
// $mail->Username = "no-replydemo.narolainfotech@gmail.com";
$mail->SetFrom('no-reply@mercoris.com', 'Mercoris Locator Utility');
$mail->Password = "Narola21";//ypur pwd
$mail->Subject = 'Other packet detected';
$mail->Body = "Other packet detected : ";
$mail->AddAddress("tr.narola@narolainfotech.com");
if (!$mail->Send()) {
    //echo $error = 'Mail error: '.$mail->ErrorInfo;
    //return false;
}
?>