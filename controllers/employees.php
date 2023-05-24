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

require 'views/employees.php';