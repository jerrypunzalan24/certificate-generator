<?php 

use Illuminate\Http\Request;

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class HomeController extends Controller{
	public function index(){
		return view('index');
	}
}
?>