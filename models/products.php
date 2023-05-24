<?php
class Products
{
	private $pdo;

	function __construct()
	{
		$host = 'localhost';
		$dbname = 'company';
		$user = 'root';
		$passwd = '';

		try {
			$this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $passwd);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function selectProducts()
	{
		try {
			$query_str = "select * from company.products";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function productByID($prd_id)
	{
		try {
			$query_str = "select * from company.products where prd_id = $prd_id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function providersProducts($prd_id)
	{
		try {
			$query_str = "select * from company.prd_providers where prd_id = $prd_id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function productProvider($prd_id, $prv_id)
	{
		try {
			$query_str = "select * from company.prd_providers where prd_id = $prd_id and prv_id = $prv_id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function createProduct($name, $description, $iva, $cat, $fee)
	{
		try {
			$query_str = "insert into company.products (name,description,iva,cat_id,fee_id) values ('$name', '$description', $iva, $cat, $fee)";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function selectFees()
	{
		try {
			$query_str = "select * from company.fees";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function selectCategories()
	{
		try {
			$query_str = "select * from company.categories";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function updateProducts($name, $cat, $iva, $fee, $description,$prd_id)
	{
		try {
			$query_str = "update company.products set name = '$name', cat_id = '$cat', iva = '$iva', fee_id = '$fee' , description = '$description' where prd_id = $prd_id;";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function disableProducts($id)
	{
		try {
			$query_str = "update company.products set status = 0 where prd_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}
}
