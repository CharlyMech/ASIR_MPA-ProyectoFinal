<?php
session_start();

if (!isset($_SESSION['user'])) {
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

function fillID($count)
{
	$count += 1;
	if (strlen(strval($count)) != 11 && $count != 0) {
		$fill = "";
		$difference = 11 - strlen(strval($count));

		for ($i = 0; $i < $difference; $i++) {
			$fill .= "0";
		}

		$fill .= $count;
	}

	if ($count == 0) {
		$fill = "00000000001";
	}

	return $fill;
}

$client_info = ($clients->selectClientByID($_SESSION['client']))[0];


$rcp_content = "";
foreach ($_SESSION['receipt'] as $line) {

	$rcp_content .= "
	<div class='row text-center'>
		<div class='col-1'>{$line['ref']}</div>
		<div class='col-4'>{$products->productByID($line['ref'])[0]['name']}</div>
		<div class='col-1'>{$line['qty']}</div>
		<div class='col-2'>{$products->productProvider($line['ref'],$line['prov'])[0]['pvp']}</div>
		<div class='col-1'>{$line['dsct']}</div>
		<div class='col-2'>" . round(($products->productProvider($line['ref'], $line['prov'])[0]['pvp'] * $line['qty']) * (1 - ($line['dsct'] / 100)), 2) . "</div>
		<div class='col-1'>{$products->productByID($line['ref'])[0]['iva']}</div>
	</div>
	";
}


$footer_content = "";
$subtotal = 0;
foreach ($_SESSION['receipt'] as $line) {
	$subtotal += round(($products->productProvider($line['ref'], $line['prov'])[0]['pvp'] * $line['qty']) * (1 - ($line['dsct'] / 100)), 2);
}

$ivas = $receipts->selectProductsGBiva($_SESSION['receipt_id']);
$rcp_ivas = "";
$rcp_bases = "";
$rcp_quota = "";
$rcp_total = 0;
foreach ($ivas as $prd_iva) {
	$count = 0;
	foreach ($_SESSION['receipt'] as $prd) {
		if ($products->productByID($prd['ref'])[0]['iva'] == $prd_iva['IVA']) {
			$count += round(($products->productProvider($prd['ref'], $prd['prov'])[0]['pvp'] * $prd['qty']) * (1 - ($prd['dsct'] / 100)), 2);
		}
	}

	$rcp_bases .= "
		<div class='row text-center'>
			$count
		</div>
	";

	$rcp_ivas .= "
	 	<div class='row text-center'>
			{$prd_iva['IVA']}
		</div>
	";

	$rcp_quota .= "
		<div class='row text-center'>".
			round($count * ($prd_iva['IVA']/100),2)
		."</div>
	";

	$rcp_total += ($count + round($count * ($prd_iva['IVA']/100),2));
}

$total = round($rcp_total,2);


require 'views/created.php';
