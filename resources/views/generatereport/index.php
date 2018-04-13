<?php 
include_once('../connectDB.php');
require('../fpdf.php');
date_default_timezone_set("Asia/Manila");
$currentday = date("F d, Y");
$query = mysqli_query($con, "SELECT * FROM data ORDER BY id DESC");
$pdf = new FPDF();
$pdf->AddPage("P");
$pdf->Image('../assets/images/rnd-logo.png',94,10,20);
$pdf->SetFont("Arial",'B','20');
$pdf->SetY(33);
$pdf->SetX(35);
$pdf->Write(5,"CCSS R&D Certifcate Generator System");
$pdf->Ln();
$pdf->SetFont("Arial",'B','14');
$pdf->SetY(43);
$pdf->SetX(65);
$pdf->Write(5,"Report generated: {$currentday}", 0,1,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->SetY(53);
$pdf->SetX(81);
$pdf->Write(5,"List of participants:", 0,1,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont("Arial",'B','12');
$pdf->Cell(60,10,"Full name",1);
$pdf->Cell(60,10,"School",1);
$pdf->Cell(70,10,"Email",1);
$pdf->Ln();
$pdf->SetFont("Arial",'','12');
while($row = mysqli_fetch_assoc($query)){
	$lastname = strtoupper($row['last_name']);
	$firstname = ucwords($row['first_name']);
	$middle_initial = strtoupper($row['middle_initial']);
	$pdf->CellFitScale(60,10, "{$lastname}, {$firstname} {$middle_initial}",1);
	$pdf->CellFitScale(60,10, "{$row['school']}",1);
	$email = ($row['email'] =='') ? 'None' : $row['email'];
	$pdf->CellFitScale(70,10,$email,1);
	$pdf->Ln();
}
$pdf->Output();
?>