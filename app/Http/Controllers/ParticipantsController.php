<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantsController extends Controller
{
	public function getparticipants(){
    $users = \DB::select("SELECT * FROM data ORDER BY id DESC");

    return view('participants.getparticipants',['users'=>$users]);
  }
  public function index(){
  	return view('participants.index');
  }
}
