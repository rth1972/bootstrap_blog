<?php
session_start();

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
$connection = mysql_connect("$host", "$user", "$password") or die ("<p class='error'>Sorry, we were unable to connect to the database server.</p>");
mysql_select_db($database, $connection) or die ("<p class='error'>Sorry, we were unable to connect to the database.</p>");

$myusername = $_REQUEST['myusername'];
$mypassword = $_REQUEST['mypassword'];
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$query = mysql_query("SELECT * FROM members WHERE username='$myusername' and password='$mypassword'");
$count=mysql_num_rows($query);
if($count==1){
while($row= mysql_fetch_array($query)){
	$email = $row['email'];
	$admin = $row['is_admin'];
	$id = $row['id'];
}
if($admin == '1'){
$_SESSION['is_admin'] = $admin;
}
// Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['myusername'] = $myusername;
$_SESSION['mypassword'] = $mypassword;
$_SESSION['email'] = $email;
$_SESSION['user_id']= $id;
echo '1';

}
else {
echo "0";
}
//echo $_SESSION['count'];
?>