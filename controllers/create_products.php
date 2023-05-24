<?php
session_start();
if (!isset($_SESSION['user'])){
	header("Location: dashboard");
	exit();
}


require "./models/products.php";
$products = new Products();


$fees = $products->selectFees();
$f_opt = "";
foreach($fees as $f){
	$f_opt .= "
		<option value='{$f['fee_id']}'>{$f['name']}</option>
	";
}

$categories = $products->selectCategories();
$cat_opt = "";
foreach($categories as $c){
	$cat_opt .= "
		<option value='{$c['cat_id']}'>{$c['name']}</option>
	";
}

$feedback = "";

if (isset($_POST['create-prd'])){
	$products->createProduct($_POST['name'],$_POST['descr'],$_POST['iva'],$_POST['cat'],$_POST['fee']);
	$feedback = " 
		<div class='alert'>
			<strong>Done!</strong> New client created.
		</div>
	";
}


require 'views/create_products.php';
