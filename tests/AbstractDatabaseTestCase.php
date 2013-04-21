<?php

abstract class AbstractDatabaseTestCase extends PHPUnit_Extensions_Database_TestCase {
	static private $pdo = null;

	private $conn = null;
	/**
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
	 */
	final public function getConnection() {
		if ($this->conn === null) {
			if (self::$pdo == null) {
				self::$pdo = new PDO('mysql:host=localhost;dbname=bp', 'root', 'root');
			}
			$this->conn = $this->createDefaultDBConnection(self::$pdo);
		}
		return $this->conn;
	}

	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	public function getDataSet() {
		return $this->createFlatXMLDataSet($_SERVER["DOCUMENT_ROOT"].'/tests/dataset.xml');
	}
}

?>