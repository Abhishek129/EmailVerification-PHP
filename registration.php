<?php
include 'includes/db.php';
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$msg="";
if(isset($_POST['submit'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$check  =mysqli_num_rows(mysqli_query($con,"select * from user WHERE email = '$email'"));

	if($check >0){
		$msg = "Email id already exist";
	}
	else{
		$id = rand(111111111,999999999);

		mysqli_query($con,"INSERT INTO user(name,email,password,verification_id,verification_status) values('$name','$email','$password',$id,0) ");

		$msg = "We 've just sent a verification link to $email<br /> 
		Please check your inbox and click on the link to get started.
		If you can't find this email (which could be due to spam filters), just request new one here.";
		
		

		$mailHtml = "Please confirm your account registration by clicking the button or link : <a href='http://localhost/email_verification/check.php?id=$id'>http://localhost/email_verification/check.php?id=$id</a>";
		smtp_mailer("$email","Account Verification",$mailHtml);
	}
	
}

function smtp_mailer($to,$subject,$msg){
    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;                      
    $mail->isSMTP();

    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'abhutank003@gmail.com';                     
    $mail->Password   = 'vcecvevmbtihjdxh';                              
    $mail->SMTPSecure = "tls";           
    $mail->Port       = 587;                                   
	$mail->CharSet = 'UTF-8';
    $mail->setFrom('verify@gmail.com');  
    $mail->addAddress($to);     
    
    $mail->isHTML(true);                                 
    $mail->Subject = $subject;
    $mail->Body    = $msg;
    if($mail->send()){
        return 0;
    }
    else{
        return 1;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
<title>Registration</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/main.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="signup-form">
    <form method="post">
		<h2>Register</h2>
		<p class="hint-text">Create your account. It's free and only takes a minute.</p>
        <div class="form-group">
        	<input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
        </div>

		<div class="form-group">
            <button type="submit" value="submit" name="submit" class="btn btn-success btn-lg btn-block">Register Now</button>
        </div>
		<div class="message">
			<?php echo $msg; ?>
		</div>
    </form>
	<div class="text-center">Already have an account? <a href="login.php">Sign in</a></div>
</div>

<script src="js/main.js"></script>


</body>
</html>