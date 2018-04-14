<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class RegisterController extends Controller{

	public function index(){
		return view('register.index');
	}


}

?>