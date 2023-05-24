<?php
class Receipts
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

	public function selectLastID()
	{
		try {
			$query_str = "select max(rcp_id) as last_id from company.receipts";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function insertNewReceipt($rcp_id, $client_id)
	{
		try {
			$query_1_str = "insert into company.receipts(rcp_id,rcp_date,cli_id) values ($rcp_id,(select curdate()),$client_id)";
			$stmt = $this->pdo->prepare($query_1_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en consulta 1: $error";
		}
	}

	public function insertNewReceiptLines($rcp_id, $prd_arr)
	{
		try {
			$query_str = "insert into company.receipts_lines values($rcp_id,{$prd_arr['ref']},{$prd_arr['prov']},{$prd_arr['qty']},{$prd_arr['dsct']},{$prd_arr['iva']})";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en consulta 2: $error";
		}
	}

	public function selectProductsGBiva($rcp_id)
	{
		try {
			$query_str = "select count(*),IVA from company.receipts_lines where rcp_id = $rcp_id GROUP by IVA;";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en consulta 2: $error";
		}
	}

	public function selectReceipts()
	{
		try {
			$query_str = "select * from company.receipts";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}

	public function disableReceipt($id)
	{
		try {
			$query_str = "update company.receipts set status = 0 where rcp_id = $id";
			$stmt = $this->pdo->prepare($query_str);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		} catch (PDOException $error) {
			echo "Error en el login: $error";
		}
	}
}
