<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('/register','RegisterController@index');
Route::post('/addparticipant', 'AjaxController@addparticipant');
Route::get('/templates', 'TemplateController@index');
// Generate Certificates, and reports
Route::get('/edit', 'GenerateController@edit');
	Route::post('/gettext','GenerateController@gettext');
	Route::get('/generate/{id}','GenerateController@view')->where('id','[0-9]+|all');
Route::get('/reports','GenerateController@reports');
//Participants page
Route::get('/participants', 'ParticipantsController@index');
Route::get('/getparticipants', 'ParticipantsController@getparticipants');
Route::get('/sample', function(Request $request){
	\DB::table('data')->insert([
		'first_name' => "hahhahhah",
		'middle_initial' => "sd",
		'last_name' => "dsadasdad",
		'school' => "asdasdasd",
		'date' => '',
		'email' => 'asdasd',
		'gender' => 1,
		'role' => 'asd'
	]);
});
