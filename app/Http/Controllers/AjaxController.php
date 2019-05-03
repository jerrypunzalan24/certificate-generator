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
			try{
			\DB::table('data')->insert([
				'first_name' => $request->input('fname'),
				'middle_initial' => $mi,
				'last_name' => $request->input('lname'),
				'school' => $school,
				'date_created' => $currentDay,
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
