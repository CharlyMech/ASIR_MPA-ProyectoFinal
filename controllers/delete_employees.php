<?php
session_start();
if (!isset($_SESSION['user'])) {
	header("Location: dashboard");
	exit();
}

if ($_SESSION['perms'] != 'admin') {
	header("Location: permissions-error");
	exit();
}


require "./models/employees.php";
$employees = new Employee();

$empl_connection = $employees->selectEmployees();
$employee_list = "";


foreach ($empl_connection as $empl) {

	$employee_list .= "
	<div class='row' style='background-color:white;'>
		<div class='col-2 border border-dark'>{$empl['emp_id']}</div>
		<div class='col-4 border border-dark'>{$empl['mail']}</div>
		<div class='col-3 border border-dark'>{$empl['name']}</div>
		<div class='col-2 border border-dark'>{$empl['perms']}</div>
		<div class='col-1 border border-dark'>
			<button name='edit' value='{$empl['emp_id']}'>&#x1f5d1;</button>
		</div>
	</div>
	";
}

$feedback = "";
$delete_verification = "";

if (isset($_POST['edit'])) {
	$delete_verification = "
		<div class='container-fluid w-50 mt-5'>
			<form method='POST' action='employees-delete'>
				<div class='row text-center mb-3'>
					<div class='col-12' style='font-size:3vh;'>
						Are you sure you want to delete the employee from employees list?
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
	$employees->disableEmployees($_POST['delete']);
	$delete_verification = "
		<div class='alert'>
			<strong>Done!</strong> Employee deleted.
		</div>
	";

	header('Location: employees-delete');
	exit();
}


require 'views/delete_employees.php';
