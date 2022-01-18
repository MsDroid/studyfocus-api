<?php

// tell browsers what type of data return
header('Content-Type:application/json');

// '*' define all website access this api, or define custom website name inplace of '*'.  
header('Access-Control-Allow-Origin: *');

// method post
header('Access-Control-Allow-Methods: POST');

// allow access all headers(use it for security reasons).
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

/*
Authorization :- authorized to origin header.
X-Requested-With :- only ajax send request.
*/

$data = json_decode(file_get_contents("php://input"), true);

/*
"php://input" :- this can read all type of row data which is received(xml,json).
file_get_content :- takes row data(json format) which is received.
*/

require '../connect.php';
require '../function.php';

$result = array();
$error = '';

// print_r($data);
// exit();

if(isset($data["email"]) && (!empty($data["email"]))){
$email = $data["email"];
$login_as = $data["type"];

$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email) {
  	$error .="Invalid email address please type a valid email address!";
	}else{
	if ($login_as == 'councellor') {
		$sel_query = "SELECT * FROM `student_info` WHERE email='".$email."'";
	}else if ($login_as == 'agency') {
		$sel_query = "SELECT * FROM `agency_info` WHERE email='".$email."'";
	}else if ($login_as == 'tutor') {
		$sel_query = "SELECT * FROM `tutor_info` WHERE email='".$email."'";
	}
	
	$results = mysqli_query($con,$sel_query);
	$row = mysqli_num_rows($results);
	if ($row==""){
  		$error .="Invalid email address please type a valid email address!";
   		array_push($result, array('error' => $error ));

		}
	}
	if($error!=""){
  		$error .="Something went wrong..";
   		array_push($result, array('error' => $error ));
		}else{
	$expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+1, date("Y"));
	$expDate = date("Y-m-d H:i:s",$expFormat);
	$key = md5(2418*2+$email);
	$addKey = substr(md5(uniqid(rand(),1)),3,10);
	$key = $key . $addKey;
// Insert Temp Table
mysqli_query($con,
"INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
VALUES ('".$email."', '".$key."', '".$expDate."');");

$output='<p>Dear user,</p>';
$output.='<p>Please click on the following link to reset your password.</p>';
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p><a href="https://studyfocus.in/cybertechMedia/api/new-study-api/reset-password/reset-password.php?key='.$key.'&email='.$email.'&login_as='.$login_as.'&action=reset" target="_blank">https://studyfocus.in/cybertechMedia/api/new-study-api/reset-password//reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';		
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';
$output.='<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.</p>';   	
$output.='<p>Thanks,</p>';
$output.='<p>Study Focus Team</p>';
$body = $output; 
$subject = "Password Recovery - Study Focus";

$email_to = $email;
$fromserver = "noreply@yourwebsite.com"; 
require("PHPMailer/PHPMailerAutoload.php");
$mail = new PHPMailer();
// $mail->IsSMTP();
$mail->Host = "mail.studyfocus.in"; // Enter your host here
$mail->SMTPAuth = true;
$mail->Username = "sumeet@studyfocus.in"; // Enter your email here
$mail->Password = "12345678"; //Enter your passwrod here
$mail->Port = 25;
$mail->IsHTML(true);
$mail->From = "sumeet@studyfocus.in";
$mail->FromName = "StudyFocus";
$mail->Sender = $fromserver; // indicates ReturnPath header
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
if(!$mail->Send()){
// echo "Mailer Error: " . $mail->ErrorInfo;
   array_push($result, array('error' => $mail->ErrorInfo ));

}else{
   array_push($result, array('success' => "Mail Sent" ));
     }

	}	

}
echo json_encode($result);

?>