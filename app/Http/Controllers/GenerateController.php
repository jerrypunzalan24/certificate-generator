<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\DB;
use Session;
class GenerateController extends Controller
{
	public function gettext(Request $request){
		$file = file_get_contents($request->file('files'));
		if($request->has('save')){ 
			$request->session()->put('location', explode(PHP_EOL, $file)[0]);
			$request->session()->put('x',$request->input('x'));
			$request->session()->put('y', $request->input('y'));
			$request->session()->put('fontsize', $request->input('fontsize'));
			$request->session()->put('font',  $request->input('font'));
			$request->session()->put('align', $request->input('align'));
			echo print_r($request->session()->all());
		}
		else{
			echo $file;
		}
	}
	public function edit(Request $request){
		if (count($request->all()) != 0){
			Fpdf::AddPage("L");
			Fpdf::setDPI(60);
			Fpdf::Addfont('Courier','',$request->input('font'));
			Fpdf::SetFont('Courier','',$request->input('fontsize'));
			Fpdf::SetXY($request->input('text_x') ?? 0, $request->input('text_y') ?? 0);
			Fpdf::centreImage("./assets/images/{$request->input('location')}/cert-speaker.jpg");
			Fpdf::Cell(0,10,$request->input('input') ?? "", 0,1,$request->input('align'));
			Fpdf::Output();
		}
	}
	public function reports(){
		date_default_timezone_set("Asia/Manila");
		$currentday = date("F d, Y");
		$query = \DB::select("SELECT * FROM data ORDER BY id DESC");
		Fpdf::AddPage("P");
		Fpdf::Image('./assets/images/rnd-logo.png',94,10,20);
		Fpdf::SetFont("Arial",'B','20');
		Fpdf::SetY(33);
		Fpdf::SetX(35);
		Fpdf::Write(5,"CCSS R&D Certifcate Generator System");
		Fpdf::Ln();
		Fpdf::SetFont("Arial",'B','14');
		Fpdf::SetY(43);
		Fpdf::SetX(65);
		Fpdf::Write(5,"Report generated: {$currentday}", 0,1,'C');
		Fpdf::Ln();
		Fpdf::Ln();
		Fpdf::SetY(53);
		Fpdf::SetX(81);
		Fpdf::Write(5,"List of participants:", 0,1,'C');
		Fpdf::Ln();
		Fpdf::Ln();
		Fpdf::SetFont("Arial",'B','12');
		Fpdf::Cell(60,10,"Full name",1);
		Fpdf::Cell(60,10,"School",1);
		Fpdf::Cell(70,10,"Email",1);
		Fpdf::Ln();
		Fpdf::SetFont("Arial",'','12');
		foreach($query as $q){
			$lastname = strtoupper($q->last_name);
			$firstname = ucwords($q->first_name);
			$middle_initial = strtoupper($q->middle_initial);
			Fpdf::CellFitScale(60,10, "{$lastname}, {$firstname} {$middle_initial}",1);
			Fpdf::CellFitScale(60,10, "{$q->school}",1);
			$email = ($q->email =='') ? 'None' : $q->email;
			Fpdf::CellFitScale(70,10,$email,1);
			Fpdf::Ln();
		}
		Fpdf::Output();
	}
	public function view($id, Request $request){
		$location = $request->session()->get('location') ?? "cert-tondohighschool";
		$align = $request->session()->get('align') ?? "C";
		$x = $request->session()->get('x') ?? 5;
		$y = $request->session()->get('y') ?? 107;
		if($id != 'all'){
			$result = \DB::select("SELECT * FROM data WHERE id = {$id}");
			Fpdf::AddPage("L");
			Fpdf::setDPI(60);
			Fpdf::AddFont('Opensans', '' , 'OpenSans-Semibold.php');
			Fpdf::SetFont('Opensans','','44');
			Fpdf::centreImage("./assets/images/{$location}/cert-{$result[0]->role}.jpg");
			$fullname = ucwords("{$result[0]->first_name} {$result[0]->middle_initial} {$result[0]->last_name}");
			Fpdf::SetXY(intval($x),intval($y));
			Fpdf::CellFitSpace(0,10,$fullname,0,1,$align);
			Fpdf::Ln(1);	

		}
		else{
			$results = \DB::select("SELECT * FROM data");
			foreach($results as $result){
				Fpdf::AddPage("L");
				Fpdf::setDPI(60);
				Fpdf::AddFont('Opensans', '' , 'OpenSans-Semibold.php');
				Fpdf::SetFont('Opensans','','44');
				Fpdf::centreImage("./assets/images/{$location}/cert-{$result->role}.jpg");
				$fullname = ucwords("{$result->first_name} {$result->middle_initial} {$result->last_name}");
				Fpdf::SetXY(intval($x),intval($y));
				Fpdf::CellFitSpace(0,10,$fullname,0,1,$align);
				Fpdf::Ln(1);
			}
		}
		Fpdf::Output();
	}
}
