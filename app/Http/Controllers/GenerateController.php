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
			$fpdf = new FPDF();
			$fpdf->AddPage("L");
			$fpdf->setDPI(60);
			$fpdf->Addfont('Courier','',$request->input('font'));
			$fpdf->SetFont('Courier','',$request->input('fontsize'));
			$fpdf->SetXY($request->input('text_x') ?? 0, $request->input('text_y') ?? 0);
			$fpdf->centreImage("./assets/images/{$request->input('location')}/cert-speaker.jpg");
			$fpdf->Cell(0,10,$request->input('input') ?? "", 0,1,$request->input('align'));
			$fpdf->Output();
		}
	}
	public function reports(){
		$fpdf = new FPDF();
		date_default_timezone_set("Asia/Manila");
		$currentday = date("F d, Y");
		$query = \DB::select("SELECT * FROM data ORDER BY id DESC");
		$fpdf->AddPage("P");
		$fpdf->Image('./assets/images/rnd-logo.png',94,10,20);
		$fpdf->SetFont("Arial",'B','20');
		$fpdf->SetY(33);
		$fpdf->SetX(35);
		$fpdf->Write(5,"CCSS R&D Certifcate Generator System");
		$fpdf->Ln();
		$fpdf->SetFont("Arial",'B','14');
		$fpdf->SetY(43);
		$fpdf->SetX(65);
		$fpdf->Write(5,"Report generated: {$currentday}", 0,1,'C');
		$fpdf->Ln();
		$fpdf->Ln();
		$fpdf->SetY(53);
		$fpdf->SetX(81);
		$fpdf->Write(5,"List of participants:", 0,1,'C');
		$fpdf->Ln();
		$fpdf->Ln();
		$fpdf->SetFont("Arial",'B','12');
		$fpdf->Cell(60,10,"Full name",1);
		$fpdf->Cell(60,10,"School",1);
		$fpdf->Cell(70,10,"Email",1);
		$fpdf->Ln();
		$fpdf->SetFont("Arial",'','12');
		foreach($query as $q){
			$lastname = strtoupper($q->last_name);
			$firstname = ucwords($q->first_name);
			$middle_initial = strtoupper($q->middle_initial);
			$fpdf->CellFitScale(60,10, "{$lastname}, {$firstname} {$middle_initial}",1);
			$fpdf->CellFitScale(60,10, "{$q->school}",1);
			$email = ($q->email =='') ? 'None' : $q->email;
			$fpdf->CellFitScale(70,10,$email,1);
			$fpdf->Ln();
		}
		$fpdf->Output();
	}
	public function view($id, Request $request){
		$location = $request->session()->get('location') ?? "cert-tondohighschool";
		$align = $request->session()->get('align') ?? "C";
		$x = $request->session()->get('x') ?? 5;
		$y = $request->session()->get('y') ?? 107;
		if($id != 'all'){
			$result = \DB::select("SELECT * FROM data WHERE id = {$id}");
			$fpdf = new FPDF();
			$fpdf->AddPage("L");
			$fpdf->setDPI(60);
			$fpdf->SetFont('Arial','','44');
			$fpdf->centreImage("./assets/images/{$location}/cert-{$result[0]->role}.jpg");
			$fullname = ucwords("{$result[0]->first_name} {$result[0]->middle_initial} {$result[0]->last_name}");
			$fpdf->SetXY(intval($x),intval($y));
			$fpdf->CellFitSpace(0,10,$fullname,0,1,$align);
			$fpdf->Ln(1);	

		}
		else{
			$results = \DB::select("SELECT * FROM data");
			foreach($results as $result){
				$fpdf->AddPage("L");
				$fpdf->setDPI(60);
				$fpdf->SetFont('Arial','','44');
				$fpdf->centreImage("./assets/images/{$location}/cert-{$result->role}.jpg");
				$fullname = ucwords("{$result->first_name} {$result->middle_initial} {$result->last_name}");
				$fpdf->SetXY(intval($x),intval($y));
				$fpdf->CellFitSpace(0,10,$fullname,0,1,$align);
				$fpdf->Ln(1);
			}
		}
		$fpdf->Output();
	}
}
