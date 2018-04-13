<?php 
require ('../fpdf.php');
session_start();
$location = $_SESSION['location'] ?? "cert-tondohighschool";
$fontname = $_SESSION['fontname'] ?? "Opensans";
$x = $_SESSION['x'] ?? 5;
$y = $_SESSION['y'] ?? 107;
$fontlocation = $_SESSION['fontlocation'] ?? "OpenSans-Semibold.php";
$align = $_SESSION['align'] ?? 'L';
include_once('../connectDB.php');
if(isset($_GET['edit'])){
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
if(isset($_GET['id'])){
	$query = mysqli_query($con, "SELECT * FROM data WHERE id = {$_GET['id']}");
	$pdf = new FPDF();
	$pdf->AddPage("L");
	$pdf->setDPI(60);
	$pdf->AddFont('Opensans', '' , 'OpenSans-Semibold.php');

	$pdf->SetFont('Opensans','','44');
// {$row['middle_initial']}. {$row['last_name']}
	while($row = mysqli_fetch_assoc($query)){
		$pdf->centreImage("../assets/images/{$location}/cert-{$row['role']}.jpg");
		$fullname = ucwords("{$row['first_name']} {$row['middle_initial']} {$row['last_name']}");
		$pdf->SetXY(intval($x),intval($y));
		$pdf->CellFitSpace(0,10,$fullname,0,1,$align);
		$pdf->Ln(1);
	}
	$pdf->Output();
}
else if(isset($_GET['all'])){
	$query = mysqli_query($con, "SELECT * FROM data");
	$pdf = new FPDF();
	$pdf->AddFont('Opensans', 'B' , $_SESSION['font']);
	$pdf->SetFont('Opensans','B',$_SESSION['fontsize']);
	$pdf->setDPI(60);
	while($row = mysqli_fetch_assoc($query)){
		$fullname = ucwords("{$row['first_name']} {$row['middle_initial']} {$row['last_name']}");
		$pdf->AddPage("L");
		$pdf->centreImage("../assets/images/{$location}/cert-{$row['role']}.jpg");
		$pdf->SetXY(intval($x),intval($y));
		$pdf->Cell(0,10,$fullname,0,1,$align);
		$pdf->Ln(1);
	}
	$pdf->Output();
}
else{
	http_response_code(404);
}
?>