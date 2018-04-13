<?php 
include('../connectDB.php');
function ucwords_new(array $arr){
	$exceptions = array("of","the","in","with", "for","and");
	foreach($arr as $index => $val){
		if(!in_array($val, $exceptions))
			$arr[$index] = ucwords($val);
	}
	return implode($arr, ' ');
}
if(isset($_POST['submit'])){
	$mi = strtoupper((preg_match( "/\.$/",$_POST['mname'])) ? $_POST['mname']  : "{$_POST['mname']}.");
	$school= ucwords_new(explode(' ',$_POST['school']));
	$currentDay = date("Y-m-d H:i:s");
	mysqli_query($con, "INSERT into data(first_name, middle_initial, last_name,school,date_created, email, gender)VALUES('{$_POST['fname']}','{$mi}','{$_POST['lname']}', '{$school}','{$currentDay}', '{$_POST['email']}', {$_POST['gender']})
		") or die(mysqli_error($con));
	$_POST = array();
}
else{
	http_response_code(404);
}
?>