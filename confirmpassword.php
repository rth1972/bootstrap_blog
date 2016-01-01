<?php
session_start();

if(isset($_SESSION['myusername'])){
	header( 'Location: http://blog.radiocarreen.com' ) ;
	exit;
}
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

$key = $_REQUEST['key'];
$password = $_REQUEST['password'];
$password = stripslashes($password);
$password = mysql_real_escape_string($password);
$sql = mysql_query("SELECT * FROM members WHERE reset='$key'") or die (mysql_error());
   while($row=mysql_fetch_array($sql)){
    $reset=$row['reset'];
    $time=$row['expire'];
    $email=$row['email'];

if (time() - $time > 86400 /* valid for 24 hours */) {
        $sql = mysql_query("UPDATE members SET expire = '', reset=''  WHERE email='$email'");
        echo "<div class='error'><h2>Sorry!</h2>Password reset link expired. Please try again!</div>";
        echo '0';
    } else {
    		$sql = mysql_query("UPDATE members SET expire = '', reset='', password = '$password' WHERE email='$email'");
    		echo '1';
    }
 }
?>