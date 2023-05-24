<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("Location: dashboard");
	exit();
}
if ($_SESSION['perms'] == 'staff'){
	header("Location: permissions-error");
	exit();
}


require "./models/clients.php";
$clients = new Clients();


$feedback = "";

if (isset($_POST['create-cli'])) {
	$clients->insertClients($_POST['nif'],$_POST['name'],$_POST['dir'],$_POST['loc'],$_POST['cp'],$_POST['tlph'],$_POST['mail']);
	$feedback = " 
		<div class='alert'>
			<strong>Done!</strong> New client created.
		</div>
	";
}


require 'views/create_clients.php';
