<?php

class UserModel extends Model {
	private $db;
	
	public function __construct(Database $db) {
		$this->db = $db;
	}

	public function findByName($name) {
		//return $this->db->query('SELECT * FROM `users` WHERE `name` LIKE :name', array(':name', $name));
		$this->db->query("SELECT * FROM `users` WHERE username = '".$name."';");
		return $this->db->resultSet();
	}

	public function getAll() {
		$this->db->query("SELECT * FROM `users`;");
		return $this->db->resultSet();
	}
	
}

?>