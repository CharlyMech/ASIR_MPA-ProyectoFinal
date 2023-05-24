<?php
session_start();

if (!isset($_SESSION['user'])){
	header("Location: dashboard");
	exit();
}

require "./models/receipts.php";
$receipts = new Receipts();

$rcp_connection = $receipts->selectReceipts();
$receipts_list = "";

foreach ($rcp_connection as $rcp){

		$receipts_list .= "
		<div class='row' style='background-color:white;'>
			<div class='col-1 border border-dark'>{$rcp['rcp_id']}</div>
			<div class='col-5 border border-dark'>{$rcp['rcp_date']}</div>
			<div class='col-5 border border-dark'>{$rcp['cli_id']}</div>
			<div class='col-1 border border-dark'>
				<button name='read' value='{$rcp['rcp_id']}'>&#x1f441;</button>
			</div>
		</div>
		";	
}

if (isset($_POST['read'])) {
	$pdf_content = "
		<embed src='/company.com/rcp_downloads/FA{$_POST['read']}.pdf' type='application/pdf' width='70%' height='850vh'/>
	";
}


require 'views/read_receipt.php';