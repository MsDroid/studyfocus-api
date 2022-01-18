<html>
<head>
<title>Reset Password - Study Focus</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css' type='text/css' media='all' />
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2>Reset Password</h2>   

<?php
include('../connect.php');
if (isset($_GET["key"]) && isset($_GET["email"])
&& isset($_GET["action"]) && ($_GET["action"]=="reset")
&& !isset($_POST["action"])){
$key = $_GET["key"];
$email = $_GET["email"];
$login_as = $_GET["login_as"];
$curDate = date("Y-m-d H:i:s");
$query = mysqli_query($con,"
SELECT * FROM `password_reset_temp` WHERE `key`='".$key."' and `email`='".$email."';");
$row = mysqli_num_rows($query);
if ($row==""){
$error .= '<h2>Invalid Link</h2>
<p>The link is invalid/expired. Either you did not copy the correct link from the email, 
or you have already used the key in which case it is deactivated.</p>
<p><a href="https://studyfocus.in/reset-password/index.php">Click here</a> to reset password.</p>';
	}else{
	$row = mysqli_fetch_assoc($query);
	$expDate = $row['expDate'];
	if ($expDate >= $curDate){
	?>
    <br />
	<form method="post" action="" name="update">
	<input type="hidden" name="action" value="update" />
	<br /><br />
	<label><strong>Enter New Password:</strong></label><br />
	<input type="password" name="pass1" id="pass1" maxlength="15" required />
    <br /><br />
	<label><strong>Re-Enter New Password:</strong></label><br />
	<input type="password" name="pass2" id="pass2" maxlength="15" required/>
    <br /><br />
	<input type="hidden" name="email" value="<?php echo $email;?>"/>
	<input type="hidden" name="login_key" value="<?php echo $login_as;?>"/>
	<input type="submit" id="reset" value="Reset Password" />
	</form>
<?php
}else{
$error .= "<h2>Link Expired</h2>
<p>The link is expired. You are trying to use the expired link which as valid only 24 hours (1 days after request).<br /><br /></p>";
				}
		}
if($error!=""){
	echo "<div class='error'>".$error."</div><br />";
	}			
} // isset email key validate end


if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"]=="update")){
$error="";
$pass1 = mysqli_real_escape_string($con,$_POST["pass1"]);
$pass2 = mysqli_real_escape_string($con,$_POST["pass2"]);
$email = $_POST["email"];
$login_key = $_POST["login_key"];
$curDate = date("Y-m-d H:i:s");
if ($pass1!=$pass2){
		$error .= "<p>Password do not match, both password should be same.<br /><br /></p>";
		}
	if($error!=""){
		echo "<div class='error'>".$error."</div><br />";
		}else{

// $pass1 = md5($pass1);
	if ($login_key == 'councellor') {
		mysqli_query($con,
"UPDATE `student_info` SET `password`='".$pass1."', `trn_date`='".$curDate."' WHERE `email`='".$email."';");
	}else if ($login_key == 'tutor') {
		mysqli_query($con,
"UPDATE `tutor_info` SET `password`='".$pass1."', `trn_date`='".$curDate."' WHERE `email`='".$email."';");
	}else if ($login_key == 'agency') {
		mysqli_query($con,
"UPDATE `agency_info` SET `password`='".$pass1."', `trn_date`='".$curDate."' WHERE `email`='".$email."';");
	}

mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `email`='".$email."';");		
	
echo '<div class="error"><p>Congratulations! Your password has been updated successfully.</p>
<p><a href="https://studyfocus.in">Click here</a> to Login.</p></div><br />';
		}		
}
?>


<br /><br />
<!--<a href="https://www.allphptricks.com/forgot-password-recovery-reset-using-php-and-mysql/"><strong>Tutorial Link</strong></a> <br /><br />-->
<!--For More Web Development Tutorials Visit: <a href="https://www.allphptricks.com/"><strong>AllPHPTricks.com</strong></a>-->
</div>
</body>
</html>