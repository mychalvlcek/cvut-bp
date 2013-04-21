<?php

class RuleModel extends Model {
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

	public function getAll() {
		//$stmt = $this->db->query("SELECT * FROM `rule`;");
		//return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
}

?>