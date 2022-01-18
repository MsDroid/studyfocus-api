<?php include '../siteurl.php' ?>
<!DOCTYPE html>

<html>
<head><title>
    Reset Password: Lextemplum
</title>
<link rel='stylesheet' href='<?php echo $site_url ?>css/style.css' type='text/css' media='all' />

<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css' type='text/css' media='all' />
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600|Questrial" rel="stylesheet" />
    <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.2/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/css/swiper.min.css" />
    <link href="../assets/css/finologymain.css?v=200720v1" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/fitodac/bsnav@master/dist/bsnav.min.css" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    
</head>
<body class="loginpage">
        <div class="navbar navbar-expand-sm bsnav bsnav-sticky bsnav-sticky-fade bg-transparent">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="<?php echo $site_url ?>/images/logo/logo2.png" class="img-fluid" style="height: 70px !important;" />
                </a>
                <button type="button" class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse justify-content-sm-end">
                    <ul class="navbar-nav navbar-mobile mr-0 mt-5 mt-md-0">
                        <li><a class="nav-link" href="<?php echo $site_url ?>/index.php">Home</a></li>
          <li><a class="nav-link" href="<?php echo $site_url ?>/about.php">About</a></li>
          <!--<li><a class="nav-link scrollto" href="../index.php#services">Services</a></li>-->
          <li><a class="nav-link" href="<?php echo $site_url ?>/courses.php">Courses</a></li>
          <!--<li><a class="nav-link scrollto" href="index.php#team">Team</a></li>-->
          <li><a class="nav-link scrollto" href="../index.php#footer">Contact</a></li>
           <li><a class="nav-link" href="<?php echo $site_url ?>/law-blog.php">Law Blogs</a></li>
          <li class="nav-item">
              <a class="nav-link" style="font-size: 0.875rem;background-color: #000000;border-radius: 0.5rem;color: #fff !important;margin: 0 0.5rem; font-weight: bold" href="<?php echo $site_url ?>/register.php"><i class="fas fa-lock"></i>&nbsp;Register</a>
          </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php
include('db.php');
if(isset($_POST["email"]) && (!empty($_POST["email"]))){
$email = $_POST["email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email) {
  	$error .="<p>Invalid email address please type a valid email address!</p>";
	}else{
	$sel_query = "SELECT * FROM `user` WHERE email='".$email."'";
	$results = mysqli_query($con,$sel_query);
	$row = mysqli_num_rows($results);
	if ($row==""){
		$error .= "<p>No user is registered with this email address!</p>";
		}
	}
	if($error!=""){
	echo "<script>alert('No user is registered with this email address!')</script>";
	echo "<script>window.open('<?php echo $site_url ?>/login.php');</script>";
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
$output.='<p><a href="<?php echo $site_url ?>/reset-password/reset-password.php?key='.$key.'&email='.$email.'&login_as='.$login_as.'&action=reset" target="_blank"><?php echo $site_url ?>/reset-password/reset-password.php?key='.$key.'&email='.$email.'&action=reset</a></p>';		
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';
$output.='<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.</p>';   	
$output.='<p>Thanks,</p>';
$output.='<p>Lextemplum Team</p>';
$body = $output; 
$subject = "Password Recovery - Lextemplum";

$email_to = $email;
$fromserver = "noreply@lextemplum.com"; 
require("PHPMailer/PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = "smtp.hostinger.com"; // Enter your host here
$mail->SMTPAuth = true;
$mail->Username = "test@lextemplum.com"; // Enter your email here
$mail->Password = "test@123S"; //Enter your passwrod here
$mail->Port = 465;
$mail->IsHTML(true);
$mail->From = "test@lextemplum.com";
$mail->FromName = "Lextemplum";
$mail->Sender = $fromserver; // indicates ReturnPath header
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
if(!$mail->Send()){
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
// echo "<div class='error'>
// <p>An email has been sent to you with instructions on how to reset your password.</p>
// </div><br /><br /><br />";
	echo "<script>alert('An email has been sent to you with instructions on how to reset your password.')</script>";
	echo "<script>window.location = '<?php echo $site_url ?>/login.php';</script>";
    // header("Location:https://thecybertize.com/projects/lex/login.php");
    // echo '<div class="error"><p>An email has been sent to you with instructions on how to reset your password..</p>
// <p><a href="https://thecybertize.com/projects/lex/login.php">Click here</a> to Login.</p></div><br />';
	}

		}	

}else{
?>
        <div class="row no-gutters">
            <div class="col-12">
                <div class="loginform">

                    <div id="updLogin">
                            <div class="signupform">
                                <div id="pnlEmail">
        
                                    <h3>Lextemplum: Reset Password</h3>
                                
                                 
                                 <form method="post" action="" name="reset">
                                    <div class="form-group"> 
                                    <label><strong>Enter Your Email Address:</strong></label>
                                    <input type="email" name="email" placeholder="username@email.com" class="form-control"/>
                                    </div>
                                    <input type="submit" class="btn btn-primary btncheck mt-4" value="Reset Password"/>
                                </form>    
                                    
                            </div>
                                
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
       <?php } ?>

        <div class="bsnav-mobile">
            <div class="bsnav-mobile-overlay"></div>
            <div class="navbar">
            </div>
        </div>
        

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.2/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fitodac/bsnav@master/dist/bsnav.min.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
     <script src="main.js"></script>

    <script>
        AOS.init();
        $('.navbar-toggler').click(function () {
            $('.bsnav-sticky').toggleClass("bg-transparent");
        });

    </script>

</body>
</html>
