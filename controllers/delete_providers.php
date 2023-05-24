<?php
session_start();

if (!isset($_SESSION['user'])) {
	header("Location: dashboard");
	exit();
}

if ($_SESSION['perms'] == 'staff') {
	header("Location: permissions-error");
	exit();
}

require "./models/providers.php";
$providers = new Providers();

$prv_connection = $providers->selectProviders();
$providers_list = "";

foreach ($prv_connection as $prv) {

	$providers_list .= "
		<div class='row' style='background-color:white;'>
			<div class='col-2 border border-dark'>{$prv['prv_id']}</div>
			<div class='col-3 border border-dark'>{$prv['nif']}</div>
			<div class='col-2 border border-dark'>{$prv['name']}</div>
			<div class='col-2 border border-dark'>{$prv['telephone']}</div>
			<div class='col-2 border border-dark'>{$prv['mail']}</div>
			<div class='col-1 border border-dark'>
				<button name='edit' value='{$prv['prv_id']}'>&#x1f5d1;</button>
			</div>
		</div>
		";
}

if (isset($_POST['edit'])) {
	$delete_verification = "
		<div class='container-fluid w-50 mt-5'>
			<form method='POST' action='providers-delete'>
				<div class='row text-center mb-3'>
					<div class='col-12' style='font-size:3vh;'>
						Are you sure you want to delete the provider from providers list?
					</div>
				</div>
				<div class='row text-center'>
					<div class='col-4'></div>
					<div class='col-4'>
						<button name='delete' value='{$_POST['edit']}' style='width:100%; font-size:2vh;'>
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
	$providers->disableProviders($_POST['delete']);
	$delete_verification = "
		<div class='alert'>
			<strong>Done!</strong> Provider disabled.
		</div>
	";

	header('Location: providers-delete');
	exit();
}


require 'views/delete_providers.php';
