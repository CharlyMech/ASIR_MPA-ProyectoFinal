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
			<button name='edit' value='{$empl['emp_id']}'>&#x270e;</button>
		</div>
	</div>
	";
}

$feedback = "";

$update_content = "";

if (isset($_POST['edit'])) {
	$_SESSION['emp_id'] = $_POST['edit'];
	$info = $employees->selectEmployeesByID($_POST['edit']);
	// print_r($employees->selectEmployeesByID($_POST['edit']));
	$update_content = "
	<div class='w-50 container-fluid mt-5'>
		<form action='employees-update' method='POST'>
			<div class='row mb-2'>
				<div class='col-4'>
					<label>Name:</label>
					<input type='text' name='name' class='form-text w-100' value='{$info[0]['name']}' required>
				</div>
				<div class='col-6'>
					<label>Surname:</label>
					<input type='text' class='form-text w-100'>
				</div>
				<div class='col-2'>
					<label>Gender:</label>
					<select class='w-100'>
						<option></option>
						<option>Male</option>
						<option>Female</option>
					</select>
				</div>
			</div>

			<div class='row mb-2'>
				<div class='col-3'>
					<label>NIF:</label>
					<input type='text' class='form-text w-100'>
				</div>
				<div class='col-5'>
					<label>Contact Mail:</label>
					<input type='email' class='form-text w-100'>
				</div>
				<div class='col-4'>
					<label class='w-100'>Contact Telephone:</label>
					<input type='text' class='form-text w-100'>
				</div>
			</div>

			<div class='row mb-2'>
				<div class='col-5'>
					<label>Internal Mail:</label>
					<input type='email' name='int_mail' class='form-text w-100' value='{$info[0]['mail']}' required>
				</div>
				<div class='col-4'>
					<label>Password:</label>
					<input type='password' name='passwd' class='form-text w-100' required>
				</div>
				<div class='col-3'>
					<label class='w-100'>Permissions: <strong>{$info[0]['perms']}</strong></label>
					<select name='perms' class='w-100' required>
						<option value='staff'>STAFF</option>
						<option value='manager'>Manager</option>
						<option value='admin'>Admin</option>
					</select>
				</div>
			</div>

			<div class='row mt-5'>
				<div class='col-4'></div>
				<div class='col-4'>
					<button class='w-100' type='submit' name='update-employee'>Update User</button>
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

if (isset($_POST['update-employee'])) {
	$employees->updateEmployees($_POST['int_mail'],$_POST['name'],$_POST['passwd'],$_POST['perms'],$_SESSION['emp_id']);
	$feedback = " 
		<div class='alert'>
			<strong>Done!</strong> Employee updated.
		</div>
	";
	header('Location: employees-update');
	exit();
}


require 'views/update_employees.php';
