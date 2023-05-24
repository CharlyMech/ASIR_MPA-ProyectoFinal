<?php
session_start();

require './models/fpdf/fpdf.php';

$pdf = new FPDF('P','mm','A4');

if (!isset($_SESSION['user'])) {
	header("Location: dashboard");
	exit();
}


// if (isset($_SESSION['receipt'], $_SESSION['receipt_id'], $_SESSION['client'])) {

// 	unset($_SESSION['receipt'], $_SESSION['receipt_id'], $_SESSION['client']);
// }

if (isset($_POST['pdf'])) {
	$pdf->AddPage();
	$pdf->SetFont('Arial', 'B', 16);
	$pdf->Cell(60, 40, "COMPANY
		Hola
	",1);
	$pdf->Output();
}


// require 'views/created.php';
