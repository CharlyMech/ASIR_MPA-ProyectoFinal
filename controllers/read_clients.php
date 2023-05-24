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

foreach ($cli_connection as $cli){

		$client_list .= "
		<div class='row' style='background-color:white;'>
			<div class='col-2 border border-dark'>{$cli['cli_id']}</div>
			<div class='col-4 border border-dark'>{$cli['nif']}</div>
			<div class='col-2 border border-dark'>{$cli['complete_name']}</div>
			<div class='col-2 border border-dark'>{$cli['telephone']}</div>
			<div class='col-2 border border-dark'>{$cli['mail']}</div>
		</div>
		";	
}


require 'views/read_clients.php';