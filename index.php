<?php

define('CONTEXT', 'company.com');

$request = $_SERVER['REQUEST_URI'];
$baserequest = basename($request);

// echo "$request <br>";

// echo basename($request) . "<br>";

switch ($baserequest) {
	case CONTEXT:
		require './controllers/index.php';
		break;
	case 'dashboard':
		require './controllers/dashboard.php';
		break;
	case 'receipts':
		require './controllers/receipts.php';
		break;
	case 'receipts-create':
		require './controllers/create_receipt.php';
		break;
	case 'created':
		require './controllers/created.php';
		break;
	case 'receipts-read':
		require './controllers/read_receipt.php';
		break;
	case 'receipts-update':
		require './controllers/update_receipt.php';
		break;
	case 'receipts-delete':
		require './controllers/delete_receipt.php';
		break;
	case 'products':
		require './controllers/products.php';
		break;
	case 'products-create':
		require './controllers/create_products.php';
		break;
	case 'products-read':
		require './controllers/read_products.php';
		break;
	case 'products-update':
		require './controllers/update_products.php';
		break;
	case 'products-delete':
		require './controllers/delete_products.php';
		break;
	case 'clients':
		require './controllers/clients.php';
		break;
	case 'clients-create':
		require './controllers/create_clients.php';
		break;
	case 'clients-read':
		require './controllers/read_clients.php';
		break;
	case 'clients-update':
		require './controllers/update_clients.php';
		break;
	case 'clients-delete':
		require './controllers/delete_clients.php';
		break;
	case 'providers':
		require './controllers/providers.php';
		break;
	case 'providers-create':
		require './controllers/create_providers.php';
		break;
	case 'providers-read':
		require './controllers/read_providers.php';
		break;
	case 'providers-update':
		require './controllers/update_providers.php';
		break;
	case 'providers-delete':
		require './controllers/delete_providers.php';
		break;
	case 'employees':
		require './controllers/employees.php';
		break;
	case 'employees-create':
		require './controllers/create_employees.php';
		break;
	case 'employees-read':
		require './controllers/read_employees.php';
		break;
	case 'employees-update':
		require './controllers/update_employees.php';
		break;
	case 'employees-delete':
		require './controllers/delete_employees.php';
		break;
	case 'permissions-error':
		require './views/permissions_error.php';
		break;
	default:
		http_response_code(404);
		require './views/404.php';
		break;
}
