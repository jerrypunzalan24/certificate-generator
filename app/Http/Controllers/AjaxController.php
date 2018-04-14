<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AjaxController extends Controller
{
	private function ucwords_new(array $arr){
		$exceptions = array("of","the","in","with", "for","and");
		foreach($arr as $index => $val){
			if(!in_array($val, $exceptions))
				$arr[$index] = ucwords($val);
		}
		return implode($arr, ' ');
	}
	public function addparticipant(Request $request){
		if ($request->has('submit')){
			$mi = strtoupper((preg_match( "/\.$/",$request->input('mname'))) ? $request->input('mname')  : "{$request->input('mname')}.");
			$school= $this->ucwords_new(explode(' ',$request->input('school')));
			$currentDay = date("Y-m-d H:i:s");
			\DB::Insert("INSERT into data(first_name, middle_initial, last_name,school,date_created, email, gender,role)VALUES('{$request->input('fname')}','{$mi}','{$request->input('lname')}', '{$school}','{$currentDay}', '{$request->input('email')}', {$request->input('gender')}, '')
				");
		}
	}
	public function gettext(Request $request){
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
	}
}
