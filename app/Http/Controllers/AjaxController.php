<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sessions;
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
			// \DB::Insert("INSERT into data(first_name, middle_initial, last_name,school,date_created, email, gender,role)VALUES('{$request->input('fname')}','{$mi}','{$request->input('lname')}', '{$school}','{$currentDay}', '{$request->input('email')}', {$request->input('gender')}, '{$request->input('role')}')
			// 	");
			try{
			\DB::table('data')->insert([
				'first_name' => $request->input('fname'),
				'middle_initial' => $mi,
				'last_name' => $request->input('lname'),
				'school' => $school,
				'date' => $currentDay,
				'email' => $request->input('email'),
				'gender' => $request->input('gender'),
				'role' => $request->input('role')
			]);
			}catch(Exception $e){
				echo $e;
			}
		}
	}

}
