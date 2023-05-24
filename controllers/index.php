<?php
session_start();

if (isset($_SESSION['id'])){
	header('Location: dashboard');
	exit();
}

$border = "border: 2px solid black";
$msg = "";

if (isset($_SESSION['log-error'])) {
	$border = "border: 2px solid red";
	$msg = " 
		<div class='alert'>
			<strong>Error!</strong> Wrong email or password.
		</div>
	";
}

require 'views/index.php';
session_destroy();
