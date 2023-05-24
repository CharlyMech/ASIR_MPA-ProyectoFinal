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

require "./models/clients.php";
$clients = new Clients();

$cli_connection = $clients->selectClients();
$client_list = "";
$update_content = "";
$feedback = "";

foreach ($cli_connection as $cli){
		$client_list .= "
		<div class='row' style='background-color:white;'>
			<div class='col-2 border border-dark'>{$cli['cli_id']}</div>
			<div class='col-3 border border-dark'>{$cli['nif']}</div>
			<div class='col-2 border border-dark'>{$cli['complete_name']}</div>
			<div class='col-2 border border-dark'>{$cli['telephone']}</div>
			<div class='col-2 border border-dark'>{$cli['mail']}</div>
			<div class='col-1 border border-dark'>
				<button name='edit' value='{$cli['cli_id']}'>&#x270e;</button>
			</div>
		</div>
		";	
}

if (isset($_POST['edit'])) {
	$_SESSION['cli_id'] = $_POST['edit'];
	$info = $clients->selectClientByID($_POST['edit']);
	$update_content = "
	<div class='w-50 container-fluid mt-5'>
			<form action='clients-update' method='POST'>
				<div class='row mb-2'>
					<div class='col-8'>
						<label>Name:</label>
						<input type='text' name='name' class='form-text w-100' value='{$info[0]['complete_name']}' required>
					</div>
					<div class='col-4'>
						<label>NIF:</label>
						<input type='text' name='nif' class='form-text w-100' value='{$info[0]['nif']}' required>
					</div>
				</div>

				<div class='row mb-2'>
					<div class='col-6'>
						<label>Direction:</label>
						<input type='text' name='dir' class='form-text w-100' value='{$info[0]['direction']}' required>
					</div>
					<div class='col-3'>
						<label>Locality:</label>
						<input type='text' name='loc' class='form-text w-100' value='{$info[0]['locality']}' required>
					</div>
					<div class='col-3'>
						<label>CP:</label>
						<input type='number' name='cp' class='form-text w-100' value='{$info[0]['cp']}' required>
					</div>
				</div>

				<div class='row mb-2'>
					<div class='col-8'>
						<label>Contact Mail:</label>
						<input type='email' name='mail' class='form-text w-100' value='{$info[0]['mail']}' required>
					</div>
					<div class='col-4'>
						<label>Contact Telephone:</label>
						<input type='number' name='tlph' class='form-text w-100' value='{$info[0]['telephone']}' required>
					</div>
				</div>

				<div class='row mt-5'>
					<div class='col-4'></div>
					<div class='col-4'>
						<button class='w-100' type='submit' name='update-cli'>Update Client</button>
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


if (isset($_POST['update-cli'])) {
	$clients->updateClients($_POST['nif'],$_POST['name'],$_POST['dir'],$_POST['loc'],$_POST['cp'],$_POST['tlph'],$_POST['mail'],$_SESSION['cli_id'],);
	$feedback = " 
		<div class='alert'>
			<strong>Done!</strong> Client updated.
		</div>
	";

	header('Location: clients-update');
	exit();
}


require 'views/update_clients.php';