<?php
$query = $_REQUEST['query'];
session_start();
// This is the composer autoloader. Used by
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';

// Explicitly including the dispatch framework,
// and our functions.php file
require 'app/includes/dispatch.php';
require 'app/includes/functions.php';

// Load the configuration file
config('source', 'app/config.ini');
$host = config('mysql.host');
$user = config('mysql.user');
$password = config('mysql.password');
$database = config('mysql.database');

$con=mysqli_connect("$host","$user","$password","$database");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql=mysqli_query($con,"SELECT * FROM blog_posts WHERE title LIKE \"%$query%\"");
$result = $sql->num_rows;
$arr = array();
$arr1 = array();
while($obj = $sql->fetch_array()){
		$id = $obj['id'];
		$title = $obj['title'];
		$post = $obj['posts'];
		$arr[] = array('title'=>$title, 'posts'=>$post);
}
$arr1[]=array('success'=>true, 'myList'=>$arr);
echo json_encode($arr);
mysqli_close($con);
?>