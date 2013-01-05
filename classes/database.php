<?php

class Database {

	private static $instance;
	private $dbh;
	private $stmt;

	private function __construct() {
		$dsn = 'mysql:host=localhost;dbname=' . Config::read('db.name');
		$options = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
					PDO::ATTR_PERSISTENT => true
					);
		try {
			$this->dbh = new PDO($dsn, Config::read('db.user'), Config::read('db.password'), $options);
		}
		catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	public static function getInstance() {
		if (!isset(self::$instance)) {
			$object = __CLASS__;
			self::$instance = new $object;
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
		$this->_queryCounter++;
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

	// returns number of rows updated, deleted, or inserted
	public function rowCount()
	{
		return $this->stmt->rowCount();
	}

}