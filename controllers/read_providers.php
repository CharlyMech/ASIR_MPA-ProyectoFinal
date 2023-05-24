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

require "./models/providers.php";
$providers = new Providers();

$prv_connection = $providers->selectProviders();
$providers_list = "";

foreach ($prv_connection as $prv){

		$providers_list .= "
		<div class='row' style='background-color:white;'>
			<div class='col-2 border border-dark'>{$prv['prv_id']}</div>
			<div class='col-4 border border-dark'>{$prv['nif']}</div>
			<div class='col-2 border border-dark'>{$prv['name']}</div>
			<div class='col-2 border border-dark'>{$prv['telephone']}</div>
			<div class='col-2 border border-dark'>{$prv['mail']}</div>
		</div>
		";	
}


require 'views/read_providers.php';