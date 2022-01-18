<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
$mail = new PHPMailer;
//  $mail = new PHPMailer();

            $mail->isSMTP();                       // telling the class to use SMTP
            $mail->SMTPDebug = 2;                  
            // 0 = no output, 1 = errors and messages, 2 = messages only.

            $mail->SMTPAuth = true;                // enable SMTP authentication
            $mail->SMTPSecure = "tls";              // sets the prefix to the servier
            $mail->Host = "smtp.hostinger.com";        // sets Gmail as the SMTP server
            $mail->Port = 587;                     // set the SMTP port for the GMAIL

            $mail->Username = "test@lextemplum.com";  // Gmail username
            $mail->Password = "test@123S";      // Gmail password

           
            $mail->SetFrom ('test@lextemplum.com'); // send to mail
            $mail->AddBCC ( 'nik2012roy@gmail.com'); // send to mail
            $mail->Subject = $subject;
            
            $mail->isHTML(true);

            $body_of_your_email ="Hello Pradeep";
            $mail->Body = $body_of_your_email; 
            // you may also use $mail->Body =       file_get_contents('your_mail_template.html');
            $mail->AddAddress ('nik2012roy@gmail.com');     
            // you may also use this format $mail->AddAddress ($recipient);

           if(!$mail->Send())
           {
              echo   $error_message = "Mailer Error: " . $mail->ErrorInfo;
            } else 
           {
           echo   $error_message = "Successfully sent!";
           }
?>