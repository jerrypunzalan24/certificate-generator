<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerateController extends Controller
{
	public function gettext(){
	
	}
	public function edit(){
		$pdf = new FPDF();
		$pdf->AddPage("L");
		$pdf->setDPI(60);
		$pdf->Addfont('Opensans','',$_GET['font']);
		$pdf->SetFont('Opensans','',$_GET['fontsize']);
		$pdf->SetXY($_GET['text_x'] ?? 0, $_GET['text_y'] ?? 0);
		$pdf->centreImage("../assets/images/{$_GET['location']}/cert-speaker.jpg");
		$pdf->Cell(0,10,$_GET['input'] ?? "", 0,1,$_GET['align']);
		$pdf->Output();
	}

	public function view(){

	}
}
