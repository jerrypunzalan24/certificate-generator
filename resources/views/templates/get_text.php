<?php
session_start();
	$file = file_get_contents($_FILES['files']['tmp_name']);

if(isset($_POST['save'])){
	$_SESSION['location'] = explode(PHP_EOL, $file)[0];
	$_SESSION['x'] = $_POST['x'];
	$_SESSION['y'] = $_POST['y'];
	$_SESSION['fontsize'] = $_POST['fontsize'];
	$_SESSION['font'] = $_POST['font'];
	$_SESSION['align'] = $_POST['align'];
}
else{
	echo $file;
}
?>

