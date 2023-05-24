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
				<button name='read' value='{$rcp['rcp_id']}'>&#x1f5d1;</button>
			</div>
		</div>
		";	
}

if (isset($_POST['read'])) {
	// $info = $receipts->disableReceipt($_POST['edit']);
	$delete_verification = "
		<div class='container-fluid w-50 mt-5'>
			<form method='POST' action='receipts-delete'>
				<div class='row text-center mb-3'>
					<div class='col-12' style='font-size:3vh;'>
						Are you sure you want to delete the receipt from receipts list?
					</div>
				</div>
				<div class='row text-center'>
					<div class='col-4'></div>
					<div class='col-4'>
						<button name='delete' value='{$_POST['read']}' style='width:100%; font-size:2vh;'>
							YES
						</button>
					</div>
					<div class='col-4'></div>
				</div>
			</form>
		</div>
	";
}

if (isset($_POST['delete'])) {
	$receipts->disableReceipt($_POST['delete']);
	$delete_verification = "
	<div class='alert'>
		<strong>Done!</strong> Receipt disabled.
	</div>
";

	header('Location: receipts-delete');
	exit();
}


require 'views/delete_receipt.php';