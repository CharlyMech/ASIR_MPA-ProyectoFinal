<?php
class Providers	
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

	public function selectProviders()
	{
		try {
			$query_str = "select * from company.providers";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function selectProviderByID($id)
	{
		try {
			$query_str = "select * from company.providers where prv_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function insertProviders($nif,$name,$direction,$locality,$cp,$tlph,$mail)
	{
		try {
			$query_str = "insert into company.providers (nif,name,direction,locality,cp,telephone,mail) values ('$nif','$name','$direction','$locality',$cp,$tlph,'$mail')";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function updateProviders($nif,$name,$direction,$locality,$cp,$tlph,$mail,$id)
	{
		try {
			$query_str = "update company.providers set nif = '$nif', name = '$name', direction ='$direction', locality = '$locality', cp = $cp, telephone = $tlph, mail = '$mail' where prv_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function disableProviders($id)
	{
		try {
			$query_str = "update company.providers set status=0 where prv_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}
}
