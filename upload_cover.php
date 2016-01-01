<?php
session_start();
$user_id = $_SESSION['user_id'];
    $size = getimagesize($_FILES['upload']['tmp_name']);
    $type = $_FILES['upload']['type'];
    $mimes = array('image/png','image/gif','image/jpeg');
    if (in_array($size['mime'], $mimes)) {
    $name = $_FILES['upload']['tmp_name'];
    $maxsize = 99999999;

    if($_FILES['upload']['size'] < $maxsize ){
    	$con=mysqli_connect("localhost","root","welkom","blog");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// A few settings

// Read image path, convert to base64 encoding
//$imgData =addslashes (file_get_contents($_FILES['filename']['tmp_name']));
$imageData = base64_encode(file_get_contents($_FILES['upload']['tmp_name']));
$arr = array();
if($result = mysqli_query($con,"UPDATE members set cover_photo='$imageData' WHERE id='$user_id'")) {
	$arr[] = array('uploaded'=>'success', 'data'=>$imageData);
	echo json_encode($arr);
} else {
	$arr[] = array('uploaded'=>'false', 'data'=>'');
	echo json_encode($arr);
}
mysqli_close($con);

    }
} else {
	echo 'file type is not allowed';
}
?>