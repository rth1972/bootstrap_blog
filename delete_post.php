<?php
session_start();
if(isset($_SESSION['myusername'])){

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
$sql = mysql_query("SELECT * FROM blog_posts WHERE id='$id'");
$nums = mysql_num_rows($sql);
if($nums > 0){
while($row = mysql_fetch_array($sql)){
$author_id = $row['author_id'];
$sql1 = mysql_query("SELECT * FROM members WHERE id='$author_id'");
$nums1 = mysql_num_rows($sql1);
if($nums1 > 0 ){
	while($row1 = mysql_fetch_array($sql1)){
		$name = $row1['username'];
	}
} else {
		echo '3';
}
}
if($name == $_SESSION['myusername']){
$sql2 = mysql_query("DELETE FROM blog_posts WHERE id='$id'");
	echo '1';
} else {
	echo '3';
}
}
} else {
	echo '3';
}
?>