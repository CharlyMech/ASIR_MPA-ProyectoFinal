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
				<button name='edit' value='{$cli['cli_id']}'>&#x1f5d1;</button>
			</div>
		</div>
		";	
}

if (isset($_POST['edit'])) {
	$info = $clients->selectClientByID($_POST['edit']);
	$delete_verification = "
		<div class='container-fluid w-25 mt-5'>
			<form method='POST' action='clients-delete'>
				<div class='row text-center mb-3'>
					<div class='col-12' style='font-size:3vh;'>
						Are you sure you want to delete <strong>". $info[0]['complete_name'] ."</strong> from clients list?
					</div>
				</div>
				<div class='row text-center'>
					<div class='col-4'></div>
					<div class='col-4'>
						<button name='delete' value='{$info[0]['cli_id']}' style='width:100%; font-size:2vh;'>
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
	$info = $clients->disableClients($_POST['delete']);
	$delete_verification = "
	<div class='alert'>
		<strong>Done!</strong> Client disabled.
	</div>
";

	header('Location: clients-delete');
	exit();
}



require 'views/delete_clients.php';