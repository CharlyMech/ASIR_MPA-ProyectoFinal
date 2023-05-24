<?php
session_start();
if (!isset($_SESSION['user'])){
	header("Location: dashboard");
	exit();
}

require "./models/clients.php";
require "./models/products.php";
require "./models/providers.php";
require "./models/receipts.php";
$clients = new Clients();
$products = new Products();
$providers = new Providers();
$receipts = new Receipts();

// function fillID($count)
// {
// 	$count += 1;
// 	if (strlen(strval($count)) != 11 && $count != 0) {
// 		$fill = "";
// 		$difference = 11 - strlen(strval($count));

// 		for ($i = 0; $i < $difference; $i++) {
// 			$fill .= "0";
// 		}

// 		$fill .= $count;
// 	}

// 	if ($count == 0) {
// 		$fill = "00000000001";
// 	}

// 	return $fill;
// 	// return $count;
// }


$clients_list = $clients->selectClients();
$clients_opt = "";

foreach ($clients_list as $cli) {
	$clients_opt .= "<option value='{$cli['cli_id']}'>{$cli['cli_id']} - {$cli['complete_name']}</option>";
}

$products_list = $products->selectProducts();
$products_opt = "";

foreach ($products_list as $prd) {
	$products_opt .= "<option value='" . $prd['prd_id'] . "'>{$prd['prd_id']} - {$prd['name']}</option>";
}

$providers_list = $providers->selectProviders();
$providers_opt = "";

foreach ($providers_list as $prv) {
	$providers_opt .= "<option value='" . $prv['prv_id'] . "'>{$prv['prv_id']} - {$prv['name']}</option>";
}

// $last_rcp_id = ;
$last_rcp_id = $receipts->selectLastID()[0]['last_id'];
$_SESSION['receipt_id'] = $last_rcp_id + 1;



if (isset($_POST['add-submit'])) {
	$err_msg = '
		<script language="javascript">alert("Quantity must be defined and numeric value!");</script>
	';

	$no_coincidence = "";
	if (empty($products->productProvider($_POST['prd'], $_POST['prv']))) {
		$no_coincidence = '
			<script language="javascript">alert("The product-provider combination possible! Ensure both fields.");</script>
		';
		// echo "Vacío";
	}

	if (!empty($_POST['qty']) && is_numeric($_POST['qty'])) {
		$err_msg = "";
		$_SESSION['client'] = $_POST['client'];

		$dsct = 0;
		if (!empty($_POST['dsct'])) {
			$dsct = $_POST['dsct'];
		}

		$_SESSION['receipt'][$_POST['prd']] = [
			'ref' => $_POST['prd'],
			'qty' => $_POST['qty'],
			'dsct' => $dsct,
			'prov' => $_POST['prv'],
			'iva' => $products->productByID($_POST['prd'])[0]['iva'],
			'html' => "
			<div class='row'>
				<div class='col-1 t-row'>" . $_POST['prd'] . "</div>
				<div class='col-3 t-row'>" . $products->productByID($_POST['prd'])[0]['name'] . "</div>
				<div class='col-1 t-row'>" . $_POST['qty'] . "</div>
				<div class='col-2 t-row'>" . $products->productProvider($_POST['prd'], $_POST['prv'])[0]['pvp'] . "</div>
				<div class='col-1 t-row'>$dsct</div>
				<div class='col-2 t-row'>" .
				round(($products->productProvider($_POST['prd'], $_POST['prv'])[0]['pvp'] * (1 - ($dsct / 100))) * $_POST['qty'], 2)
				. "</div>
				<div class='col-1 t-row'>" . $products->productByID($_POST['prd'])[0]['iva'] . "</div>
				<div class='col-1 t-row'>
					<button name='delete' value='" . $_POST['prd'] . "' class='btn-close' ></button>
				</div>
			</div>
			"
		];
	}
}

// print_r($_SESSION['receipt']);

if (isset($_POST['delete'])) {
	foreach ($_SESSION['receipt'] as $prd_line) {
		if ($prd_line['ref'] == $_POST['delete']) {
			unset($_SESSION['receipt'][$_POST['delete']]);
		}
	}
}

if (isset($_POST['submit-receipt']) && empty($_SESSION['receipt'])) {
	$empty_msg = "
		<script language='javascript'>alert('Receipt must have at least 1 item!');</script>
	";
}
if (isset($_POST['submit-receipt']) && !empty($_SESSION['receipt'])) {
	$insert_new_rcp = $receipts->insertNewReceipt($_SESSION['receipt_id'],$_SESSION['client']);
	foreach ($_SESSION['receipt'] as $line) {
		$insert_new_rcp_line = $receipts->insertNewReceiptLines($_SESSION['receipt_id'],$line);
	}
	
	header('Location: created');
	exit();
}

require 'views/create_receipt.php';
