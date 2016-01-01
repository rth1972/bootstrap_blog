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

$title = $_REQUEST['title'];
$title = stripslashes($title);
$title = mysql_real_escape_string($title);

$content = $_REQUEST['content'];
$content = stripslashes($content);
$content = mysql_real_escape_string($content);

$category = $_REQUEST['category'];
$category = stripslashes($category);
$category = mysql_real_escape_string($category);

$author_id = $_SESSION['user_id'];
$date = time();

if($sql = mysql_query("INSERT INTO blog_posts VALUES (NULL, '$title', '$content', '$author_id','$date','1','0', '$category')")){
	echo '1';
		} else {
	echo '2';
		}
?>