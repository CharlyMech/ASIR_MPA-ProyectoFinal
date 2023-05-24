<?php
session_start();

if (!isset($_SESSION['user'])){
	header("Location: dashboard");
	exit();
}


require 'views/products.php';