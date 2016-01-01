<?php
require 'vendor/autoload.php';

// Explicitly including the dispatch framework,
// and our functions.php file
require 'app/includes/dispatch.php';
require 'app/includes/functions.php';
config('source', 'app/config.ini');

$host = config('mysql.host');
$user = config('mysql.user');
$password = config('mysql.password');
$database = config('mysql.database');
$team = config('blog.title');
$connection = mysql_connect("$host", "$user", "$password") or die ("<p class='error'>Sorry, we were unable to connect to the database server.</p>");
mysql_select_db($database, $connection) or die ("<p class='error'>Sorry, we were unable to connect to the database.</p>");

$myusername = $_REQUEST['myusername'];
$myusername = stripslashes($myusername);
$myusername = mysql_real_escape_string($myusername);

$query = mysql_query("SELECT * FROM members WHERE username='$myusername'");
$count=mysql_num_rows($query);
if($count==1){
while($row= mysql_fetch_array($query)){
	$email = $row['email'];
require("phpmailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.radiocarreen.com"; // SMTP server
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = "info@radiocarreen.com"; // SMTP account username
$mail->Password   = "welkom";        // SMTP account password
$user=$row->id;
$mail->From = "info@radiocarreen.com";
$mail->FromName = "Blog";
$mail->AddAddress($email);
//$mail->AddBCC($email, '');
$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject = site_url()." password reset confirmation";

$salt = sha1(uniqid()); //generate salt
$now = time(); //get current time

//forgot key
$forgot_key=sha1($user . $now . $salt);
//echo $forgot_key;

$update['expire'] = $now;
$update['reset'] = $forgot_key;
$sql = mysql_query("UPDATE members SET expire='$now', reset='$forgot_key' WHERE email='$email'"); 
$mailer = "<div style='margin: 0 auto; width: 520px; padding: 12px;'><br><br>Hi ".$row->username.",<br><br> There was recently a request to change the password on your account. If you requested this password change, please set a new password by following the link below:<br><br>
				<a href='".site_url()."resetpassword.php?key=".$forgot_key."'>".site_url()."resetpassword.php?key=".$forgot_key."</a><br><br>Please note that this link is valid only for 24 hours.<br><br>If you don't want to change your password, just ignore this message.<br><br>Thanks,<br>".config('blog.title')."</div>";
$mail->Body = $mailer;

if(!$mail->Send()) {
	echo "Message could not be sent.<p>Mailer Error: " . $mail->ErrorInfo."</p>";
	exit;
} else {
 echo '1';
}
}
// Register $myusername, $mypassword and redirect to file "login_success.php"
}
else {
echo "0";
}
//echo $_SESSION['count'];
?>