<?php

class LogModel extends Model {
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

	public function getAll() {
		$stmt = $this->db->query("SELECT * FROM `comparison_log`;");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function findById($id) {
		//return $this->db->query('SELECT * FROM `users` WHERE `name` LIKE :name', array(':name', $name));
		$this->db->query("SELECT * FROM `comparison_log` WHERE `id` = '".$id."';");
		return $this->db->resultSet();
	}
	
}

?>