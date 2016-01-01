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
$connection = mysql_connect("$host", "$user", "$password") or die ("<p class='error'>Sorry, we were unable to connect to the database server.</p>");
mysql_select_db($database, $connection) or die ("<p class='error'>Sorry, we were unable to connect to the database.</p>");

$id = $_REQUEST['id'];
$sql = mysql_query("SELECT * FROM category WHERE id='$id'");
$nums = mysql_num_rows($sql);
if($nums > 0){
	echo '0';
} else {
	$sql1 = mysql_query("INSERT INTO category VALUES (NULL, '$id')");
	echo '1';
}
?>