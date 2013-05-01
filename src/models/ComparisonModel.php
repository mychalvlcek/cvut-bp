<?php

class ComparisonModel extends Model {

	public function insert($data) {
		$stmt = $this->db->prepare('INSERT INTO `comparison_log` (repository_id, script_dir_id, rule, author) VALUES (:repository, :script_dir, :rule, :author)');
		$result = $stmt->execute(array(':repository' => $data['repository'], ':script_dir' => $data['script_dir'], ':rule' => $data['rule'], ':author' => $data['author']));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function getAll() {
		$stmt = $this->db->query('SELECT l.*, r.name, DATE_FORMAT(date_of_comparison, "%d.%m. %H:%i") AS datef FROM `comparison_log` AS l 
									LEFT JOIN `repository` AS r ON r.id = l.repository_id;');
		return $stmt->fetchAll();
	}

	public function getScriptSets() {
		$stmt = $this->db->query('SELECT * FROM `script`;');
		return $stmt->fetchAll();
	}

	public function getRepositories() {
		$stmt = $this->db->query('SELECT * FROM `repository`;');
		return $stmt->fetchAll();
	}

	public function getRules() {
		return array(
				array('id' => 'PRESNA_SHODA', 'name' => 'Přesná shoda řetězce'),
				array('id' => 'SHODA_PODRETEZCE', 'name' => 'Shoda podřetězce'),
				array('id' => 'SHODA_S_TOLERANCI', 'name' => 'Shoda s tolerancí')
			);
	}

	public function findById($id) {

		$stmt = $this->db->prepare('SELECT l.*, r.name, DATE_FORMAT(date_of_comparison, "%d.%m. %H:%i") AS datef FROM `comparison_log` AS l 
									LEFT JOIN `repository` AS r ON r.id = l.repository_id
									WHERE `l`.`id` = :id;');
		$stmt->execute(array(':id' => $id));
		//print_r($stmt->fetch());
		return $stmt->fetch();
	}

}

?>