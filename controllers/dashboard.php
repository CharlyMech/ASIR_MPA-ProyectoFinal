<?php
session_start();

if (isset($_SESSION['receipt'],$_SESSION['client'],$_SESSION['receipt_id'])){
	unset($_SESSION['receipt'],$_SESSION['client'],$_SESSION['receipt_id']);
}

require "./models/employees.php";
$emp = new Employee();


if (isset($_POST['submit'])) {
	$user_validation = $emp->checkUserLogin($_POST['login']['mail']);

	if (empty($user_validation) || md5($_POST['login']['passwd']) != $user_validation[0]['passwd']) {
		$_SESSION['log-error'] = "";
		header('Location: /company.com');
		exit();
	}

	$user_session_info = $emp->userSessionInfo($_POST['login']['mail']);
	$_SESSION['id'] = $user_session_info[0]['emp_id'];
	$_SESSION['user'] = $user_session_info[0]['name'];
	$_SESSION['perms'] = $user_session_info[0]['perms'];
} else {
	if (!isset($_SESSION['id'])) {
		header('Location: /company.com');
		exit();
	}
}


$user_opt = "";

switch ($_SESSION['perms']) {
	case 'admin':
		$user_opt = "
			<a class='section-btn' href='receipts'>Receipts</a>
			<a class='section-btn' href='products'>Products</a>
			<a class='section-btn' href='clients'>Clients</a>
			<a class='section-btn' href='providers'>Providers</a>
			<a class='section-btn' href='employees'>Employees</a>
		";
		break;
	case 'manager':
		$user_opt = "
			<a class='section-btn' href='receipts'>Receipts</a>
			<a class='section-btn' href='products'>Products</a>
			<a class='section-btn' href='clients'>Clients</a>
			<a class='section-btn' href='providers'>Providers</a>
		";
		break;
	case 'staff':
		$user_opt = "
			<a class='section-btn' href='receipts'>Receipts</a>
			<a class='section-btn' href='products'>Products</a>
		";
		break;
}


require 'views/dashboard.php';
