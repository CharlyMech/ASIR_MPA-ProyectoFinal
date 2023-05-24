<?php
session_start();

if (!isset($_SESSION['user'])){
	header("Location: dashboard");
	exit();
}

require "./models/employees.php";
$employees = new Employee();

$empl_connection = $employees->selectEmployees();
$employee_list = "";

foreach ($empl_connection as $empl){

		$employee_list .= "
		<div class='row' style='background-color:white;'>
			<div class='col-2 border border-dark'>{$empl['emp_id']}</div>
			<div class='col-4 border border-dark'>{$empl['mail']}</div>
			<div class='col-3 border border-dark'>{$empl['name']}</div>
			<div class='col-3 border border-dark'>{$empl['perms']}</div>
		</div>
		";	
}


require 'views/read_employees.php';