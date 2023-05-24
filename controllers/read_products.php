<?php
session_start();

if (!isset($_SESSION['user'])){
	header("Location: dashboard");
	exit();
}

require "./models/products.php";
$products = new Products();

$prd_connection = $products->selectProducts();
$product_list = "";

foreach ($prd_connection as $prd){

	$prd_prv = $products->providersProducts($prd['prd_id']);

	foreach ($prd_prv as $prv){
		$product_list .= "
		<div class='row' style='background-color:white;'>
			<div class='col-2 border border-dark'>{$prd['prd_id']}</div>
			<div class='col-4 border border-dark'>{$prd['name']}</div>
			<div class='col-2 border border-dark'>{$prd['cat_id']}</div>
			<div class='col-1 border border-dark'>{$prd['stock']}</div>
			<div class='col-2 border border-dark'>{$prv['prv_id']}</div>
			<div class='col-1 border border-dark'>{$prv['pvp']}</div>
		</div>
		";
	}

	
}


require 'views/read_products.php';