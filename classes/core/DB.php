<?php

include_once('Config.php');

/**
 * PDO class extension
 *
 * @author vlcekmi3
 */
class DB extends PDO {
	public $pdo;
	private static $instance;

	private function __construct() {

		$dsn = Config::read('db.engine') .
				':host=' . Config::read('db.host') .
				';dbname=' . Config::read('db.basename') .
				';port=' . Config::read('db.port') .
				';connect_timeout=15';

		$user = Config::read('db.user');
		$password = Config::read('db.password');

		$this->pdo = new PDO($dsn, $user, $password);
	}

	public static function getInstance() {
		if (!isset(self::$instance)) {
			$object = __CLASS__;
			self::$instance = new $object;
		}
		return self::$instance;
	}
	
	public function query( $statement, $input_parameters = array() ) {
		$result = $this->prepare($statement);
		$result->setFetchMode(PDO::FETCH_ASSOC);
		return ($result && $result->execute($input_parameters) ? $result : false);
	}
	
	public function exec( $statement, $input_parameters = array() ) {
		$result = $this->query($statement, $input_parameters);
		return ($result ? $result->rowCount() : false);
	}

}

?>