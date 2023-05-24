<?php
class Employee
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

	public function selectEmployees()
	{
		try {
			$query_str = "select * from company.employees";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function checkUserLogin($mail)
	{
		try {
			$query_str = "select passwd from company.employees where mail='$mail'";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function userSessionInfo($mail)
	{
		try {
			$query_str = "select emp_id,name,perms from company.employees where mail='$mail'";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function createEmployees($int_mail, $name, $passwd, $perms)
	{
		try {
			$md5_passwd = md5($passwd);
			$query_str = "insert into company.employees (mail,name,passwd,perms) values ('$int_mail','$name','$md5_passwd','$perms')";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function selectEmployeesByID($id)
	{
		try {
			$query_str = "select * from company.employees where emp_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function updateEmployees($int_mail,$name,$passwd,$perms,$emp_id)
	{
		try {
			$md5_passwd = md5($passwd);
			$query_str = "update company.employees set mail = '$int_mail', name = '$name', passwd = '$md5_passwd', perms = '$perms' where emp_id = $emp_id;";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function disableEmployees($id)
	{
		try {
			$query_str = "delete from company.employees where emp_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}
}
