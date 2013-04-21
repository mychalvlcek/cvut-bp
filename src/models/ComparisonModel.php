<?php

class ComparisonModel extends Model {
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

	public function insert($data) {
		$stmt = $this->db->prepare('INSERT INTO `comparison_log` (repository_id, script_dir_id, author) VALUES (:repository, :script_dir, :author)');
		$result = $stmt->execute(array(':repository' => $data['repository'], ':script_dir' => $data['script_dir'], ':author' => $data['author']));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

}

?>