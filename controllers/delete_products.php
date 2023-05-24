<?php
session_start();

if (!isset($_SESSION['user'])){
	header("Location: dashboard");
	exit();
}

if ($_SESSION['perms'] == 'staff'){
	header("Location: permissions-error");
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
			<div class='col-1 border border-dark'>{$prv['prv_id']}</div>
			<div class='col-1 border border-dark'>{$prv['pvp']}</div>
			<div class='col-1 border border-dark'>
				<button name='edit' value='{$prd['prd_id']}'>&#x1f5d1;</button>
			</div>
		</div>
		";
	}
}

if (isset($_POST['edit'])) {
	$info = $products->productByID($_POST['edit']);
	$delete_verification = "
		<div class='container-fluid w-25 mt-5'>
			<form method='POST' action='products-delete'>
				<div class='row text-center mb-3'>
					<div class='col-12' style='font-size:3vh;'>
						Are you sure you want to delete the product from products list?
					</div>
				</div>
				<div class='row text-center'>
					<div class='col-4'></div>
					<div class='col-4'>
						<button name='delete' value='{$info[0]['prd_id']}' style='width:100%; font-size:2vh;'>
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
	$info = $products->disableProducts($_POST['delete']);
	$delete_verification = "
	<div class='alert'>
		<strong>Done!</strong> Product disabled.
	</div>
";

	header('Location: products-delete');
	exit();
}



require 'views/delete_products.php';