<?php
class Clients	
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

	public function selectClients()
	{
		try {
			$query_str = "select * from company.clients";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function selectClientByID($id)
	{
		try {
			$query_str = "select * from company.clients where cli_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function insertClients($nif,$name,$direction,$locality,$cp,$tlph,$mail)
	{
		try {
			$query_str = "insert into company.clients (nif,complete_name,direction,locality,cp,telephone,mail) values ('$nif','$name','$direction','$locality',$cp,$tlph,'$mail')";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function updateClients($nif,$name,$direction,$locality,$cp,$tlph,$mail,$id)
	{
		try {
			$query_str = "update company.clients set nif = '$nif', complete_name = '$name', direction ='$direction', locality = '$locality', cp = $cp, telephone = $tlph, mail = '$mail' where cli_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function disableClients($id)
	{
		try {
			$query_str = "update company.clients set status=0 where cli_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}
}
