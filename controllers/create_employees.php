<?php
session_start();
if (!isset($_SESSION['user'])){
	header("Location: dashboard");
	exit();
}

if ($_SESSION['perms'] != 'admin'){
	header("Location: permissions-error");
	exit();
}


require "./models/employees.php";
$employees = new Employee();

$feedback = "";

if (isset($_POST['create-emplyee'])){
	$employees->createEmployees($_POST['int_mail'],$_POST['name'],$_POST['passwd'],$_POST['perms']);
	$feedback = " 
		<div class='alert'>
			<strong>Done!</strong> New client created.
		</div>
	";
}


require 'views/create_employees.php';
