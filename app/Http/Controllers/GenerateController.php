<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\FPDF;
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
			FPDF::AddPage("L");
			FPDF::setDPI(60);
			FPDF::Addfont('Courier','',$request->input('font'));
			FPDF::SetFont('Courier','',$request->input('fontsize'));
			FPDF::SetXY($request->input('text_x') ?? 0, $request->input('text_y') ?? 0);
			FPDF::centreImage("./assets/images/{$request->input('location')}/cert-speaker.jpg");
			FPDF::Cell(0,10,$request->input('input') ?? "", 0,1,$request->input('align'));
			FPDF::Output();
		}
	}
	public function reports(){
		date_default_timezone_set("Asia/Manila");
		$currentday = date("F d, Y");
		$query = \DB::select("SELECT * FROM data ORDER BY id DESC");
		FPDF::AddPage("P");
		FPDF::Image('./assets/images/rnd-logo.png',94,10,20);
		FPDF::SetFont("Arial",'B','20');
		FPDF::SetY(33);
		FPDF::SetX(35);
		FPDF::Write(5,"CCSS R&D Certifcate Generator System");
		FPDF::Ln();
		FPDF::SetFont("Arial",'B','14');
		FPDF::SetY(43);
		FPDF::SetX(65);
		FPDF::Write(5,"Report generated: {$currentday}", 0,1,'C');
		FPDF::Ln();
		FPDF::Ln();
		FPDF::SetY(53);
		FPDF::SetX(81);
		FPDF::Write(5,"List of participants:", 0,1,'C');
		FPDF::Ln();
		FPDF::Ln();
		FPDF::SetFont("Arial",'B','12');
		FPDF::Cell(60,10,"Full name",1);
		FPDF::Cell(60,10,"School",1);
		FPDF::Cell(70,10,"Email",1);
		FPDF::Ln();
		FPDF::SetFont("Arial",'','12');
		foreach($query as $q){
			$lastname = strtoupper($q->last_name);
			$firstname = ucwords($q->first_name);
			$middle_initial = strtoupper($q->middle_initial);
			FPDF::CellFitScale(60,10, "{$lastname}, {$firstname} {$middle_initial}",1);
			FPDF::CellFitScale(60,10, "{$q->school}",1);
			$email = ($q->email =='') ? 'None' : $q->email;
			FPDF::CellFitScale(70,10,$email,1);
			FPDF::Ln();
		}
		FPDF::Output();
	}
	public function view($id, Request $request){
		$location = $request->session()->get('location') ?? "cert-tondohighschool";
		$align = $request->session()->get('align') ?? "C";
		$x = $request->session()->get('x') ?? 5;
		$y = $request->session()->get('y') ?? 107;
		if($id != 'all'){
			$result = \DB::select("SELECT * FROM data WHERE id = {$id}");
			FPDF::AddPage("L");
			FPDF::setDPI(60);
			FPDF::AddFont('Opensans', '' , 'OpenSans-Semibold.php');
			FPDF::SetFont('Opensans','','44');
			FPDF::centreImage("./assets/images/{$location}/cert-{$result[0]->role}.jpg");
			$fullname = ucwords("{$result[0]->first_name} {$result[0]->middle_initial} {$result[0]->last_name}");
			FPDF::SetXY(intval($x),intval($y));
			FPDF::CellFitSpace(0,10,$fullname,0,1,$align);
			FPDF::Ln(1);	

		}
		else{
			$results = \DB::select("SELECT * FROM data");
			foreach($results as $result){
				FPDF::AddPage("L");
				FPDF::setDPI(60);
				FPDF::AddFont('Opensans', '' , 'OpenSans-Semibold.php');
				FPDF::SetFont('Opensans','','44');
				FPDF::centreImage("./assets/images/{$location}/cert-{$result->role}.jpg");
				$fullname = ucwords("{$result->first_name} {$result->middle_initial} {$result->last_name}");
				FPDF::SetXY(intval($x),intval($y));
				FPDF::CellFitSpace(0,10,$fullname,0,1,$align);
				FPDF::Ln(1);
			}
		}
		FPDF::Output();
	}
}
