<?php

class Database {

	private $dbh;
	private static $instance;
	private $stmt;

	private function __construct($dbDriver = DB_DRIVER,
								 $dbHost = DB_HOST,
								 $dbUser = DB_USER,
								 $dbPass = DB_PASSWORD,
								 $dbName = DB_NAME
								 ) {

		$dsn = $dbDriver.':host='.$dbHost.';dbname=' . $dbName;
		$options = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
					PDO::ATTR_PERSISTENT => true
					);
		try {
			$this->dbh = new PDO($dsn, $dbUser, $dbPass, $options);
		} catch (PDOException $e) {
			trigger_error($e->getMessage());
			exit();
		}
	}

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new Database();
		}
		return self::$instance;
	}

	public function query($query) {
		$this->stmt = $this->dbh->prepare($query);
	}

	public function bind($pos, $value, $type = null) {
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($pos, $value, $type);
	}

	public function execute() {
		//$this->_queryCounter++;
		return $this->stmt->execute();
	}

	public function resultset() {
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function single() {
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function lastInsertId() {
		return $this->dbh->lastInsertId();
	}

	// begin transaction // must be innoDatabase table
	public function beginTransaction() {
		return $this->dbh->beginTransaction();
	}

	public function commit() {
		return $this->dbh->commit();
	}

	public function rollBack() {
		return $this->dbh->rollBack();
	}

	/**
	 * Returns number of rows updated, deleted, or inserted
	 * @return int number of rows
	 */
	public function rowCount() {
		return $this->stmt->rowCount();
	}

}