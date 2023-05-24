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
$update_content = "";
$feedback = "";

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
				<button name='edit' value='{$prd['prd_id']}'>&#x270e;</button>
			</div>
		</div>
		";
	}
}


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


if (isset($_POST['edit'])) {
	$_SESSION['prd_id'] = $_POST['edit'];
	$info = $products->productByID($_POST['edit']);
	$update_content = "
	<div class='w-50 container-fluid mt-5'>
		<form action='products-update' method='POST'>
			<div class='row mb-2'>
				<div class='col-6'>
					<label>Name:</label>
					<input type='text' name='name' class='form-text w-100' value='{$info[0]['name']}' required>
				</div>
				<div class='col-2'>
					<label>Category:</label>
					<select class='w-100' name='cat'>
						<option>{$info[0]['cat_id']}</option>
						<?= $cat_opt ?>
					</select>
				</div>
				<div class='col-2'>
					<label>IVA:</label>
					<select class='w-100' name='iva'>
						<option>{$info[0]['iva']}</option>
						<option value='4'>4</option>
						<option value='10'>10</option>
						<option value='21'>21</option>
					</select>
				</div>
				<div class='col-2'>
					<label>FEE:</strong></label>
					<select class='w-100' name='fee'>
						<option>{$info[0]['fee_id']}</option>
						<?= $f_opt ?>
					</select>
				</div>
			</div>

			<div class='row mb-2'>
				<div class='col-12'>
					<label>Description:</label>
					<textarea name='descr' cols='40' rows='5' class='w-100'>{$info[0]['description']}</textarea>
				</div>
			</div>

			<div class='row mt-5'>
				<div class='col-4'></div>
				<div class='col-4'>
					<button class='w-100' type='submit' name='update-prd'>Update Product</button>
				</div>
				<div class='col-4'></div>
			</div>
		</form>

		<div class='row mt-5'>
			<div class='col-1'></div>
			<div class='col-10'>
				<?= $feedback ?>
			</div>
			<div class='col-1'></div>
		</div>
	</div>
	";
}

if (isset($_POST['update-prd'])) {
	$products->updateProducts($_POST['name'],$_POST['cat'],$_POST['iva'],$_POST['fee'],$_POST['descr'],$_SESSION['prd_id']);
	$feedback = " 
		<div class='alert'>
			<strong>Done!</strong> Product updated.
		</div>
	";

	header('Location: products-update');
	exit();
}



require 'views/update_products.php';