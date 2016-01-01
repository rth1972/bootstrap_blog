<?php
if(isset($_POST['submit'])) {
	$email = $_POST['email'];
	$email = htmlspecialchars($email); //clean from bas code
	
	if(empty($email)) {
		echo "";
	}
	if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
	echo "<div class='error'>Sorry, The email address is invalid!</div>";
	}
	else {
	$sql = mysql_query("SELECT id,email,username FROM members WHERE email='$email'") or die (mysql_error());
	if(mysql_affected_rows()==0) {
		echo "<div class='error'>No account with that email address exists.</div>";
	}
	else { 
	while($row=mysql_fetch_object($sql)) {

require("phpmailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "ssl://smtp.googlemail.com"; // SMTP server
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 465;                    // set the SMTP port for the GMAIL server
$mail->Username   = "no-reply@limopalm.com"; // SMTP account username
$mail->Password   = "your-password-here";        // SMTP account password

$email = $row->email;
$user=$row->id;
$mail->From = "no-reply@limopalm.com";
$mail->FromName = "Limopalm Tutorial";
$mail->AddAddress($email);
//$mail->AddBCC($email, '');
$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject = "Limopalm password reset confirmation";

$salt = sha1(uniqid()); //generate salt
$now = time(); //get current time

//forgot key
$forgot_key=sha1($user . $now . $salt);
//echo $forgot_key;

$update['expire'] = $now;
$update['reset'] = $forgot_key;
$db->query_update('users', $update, "email='$email'"); //update with password expiry time

$mailer = "<div style='margin: 0 auto; background: #212121; color: #ccc; width: 520px; padding: 12px;'><img src='http://limopalm.com/images/limopalm.png'><br><br>Hi ".$row->username.",<br><br> There was recently a request to change the password on your account. If you requested this password change, please set a new password by following the link below:<br><br>
				<a href='http://limopalm.com/blog/wp-content/uploads/2011/06/forgot-password-feature-for-your-next-web-project?key=".$forgot_key."'>http://limopalm.com/blog/wp-content/uploads/2011/06/forgot-password-feature-for-your-next-web-project?key=".$forgot_key."</a><br><br>Please note that this link is valid only for 24 hours.<br><br>If you don't want to change your password, just ignore this message.<br><br>This is sent from a <a href='http://limopalm.com/blog/wp-content/uploads/2011/06/forgot-password-feature-for-your-next-web-project/#'>tutorial</a> on limopalm blog. If you did not register by yourself let us know at info@limopalm.com<br><br>Thanks,<br>Limopalm Team</div>";
$mail->Body = $mailer;

if(!$mail->Send()) {
	echo "Message could not be sent.<p>";
	echo "Mailer Error: " . $mail->ErrorInfo;
	exit;
}

//echo $mailer;

echo '<div class="success">An email has been sent to '.$email.' with further instructions.</div>';
//$_SESSION['forgotemail']=$email;

//header('Location: http://limopalm.com/login');   //redirect to the approprite page after sending the request.
	
	}
	}
}
}
?>