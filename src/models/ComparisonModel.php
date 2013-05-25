<?php

class ComparisonModel extends Model {

	public function insert($data) {
		$stmt = $this->db->prepare('INSERT INTO `comparison_log` (name, repository_id, script_dir_id, rule, author) VALUES (:name, :repository, :script_dir, :rule, :author)');
		$result = $stmt->execute(array(':name' => $data['name'], ':repository' => $data['repository'], ':script_dir' => $data['script_dir'], ':rule' => $data['rule'], ':author' => $data['author']));
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	public function insertElement($data) {
		$stmt = $this->db->prepare('INSERT INTO `log_repository_elements` (log_id, element_id, element_type, occurrences_in_script) VALUES (?, ?, ?, ?)');
		$result = $stmt->execute($data);
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	public function insertScript($data) {
		$stmt = $this->db->prepare('INSERT INTO `log_scripts` (log_id, script_id, contains_element) VALUES (?, ?, ?)');
		$result = $stmt->execute($data);
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	public function delete($id) {
		try {
			$stmt = $this->db->prepare('DELETE FROM `comparison_log` WHERE id = :id');
			$result = $stmt->execute(array(':id' => $id));
			// AFTER DELETE trigger
			if($stmt && $result) {
				$trgrstmt = $this->db->prepare('DELETE FROM `log_repository_elements` WHERE log_id = :id');
				$result = $trgrstmt->execute(array(':id' => $id));
				$trgrstmt = $this->db->prepare('DELETE FROM `log_scripts` WHERE log_id = :id');
				$result = $trgrstmt->execute(array(':id' => $id));
			}
			return $stmt && $result ? $stmt->rowCount() : false;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function getAll() {
		$stmt = $this->db->query('SELECT l.*, s.name AS dir, r.name AS repository, DATE_FORMAT(date_of_comparison, "%d.%m. %H:%i") AS datef FROM `comparison_log` AS l 
									LEFT JOIN `repository` AS r ON r.id = l.repository_id
									LEFT JOIN `script_dir` AS s ON s.id = l.script_dir_id
									ORDER BY '.$this->sort.' '.$this->sortOrder.' '.$this->getLimitString().';');
		return $stmt->fetchAll();
	}


	public function getAllCount() {
		return $this->db->query('SELECT COUNT(*) FROM `comparison_log`;')->fetchColumn();
	}

	public function getScriptSets() {
		$stmt = $this->db->query('SELECT * FROM `script_dir` ORDER BY name ASC;');
		return $stmt->fetchAll();
	}

	public function getAllScriptsByDir($id) {
		echo $id;
		$stmt = $this->db->prepare('SELECT sc.*, GROUP_CONCAT(st.title) AS steps_title, GROUP_CONCAT(st.description) AS steps_description,  GROUP_CONCAT(st.expected_result) AS steps_result FROM `script` AS sc
									LEFT JOIN `script_step` AS st ON st.script = sc.id
									WHERE  sc.dir_id = :directory
									GROUP BY st.script;');
		$stmt->execute(array(':directory' => $id));
		return $stmt->fetchAll();
	}

	public function getElementsByRepository($id) {
		$stmt = $this->db->prepare('SELECT id, label, value, type FROM `repository_html`
									WHERE repository_id = :repository
									UNION ALL
									SELECT id, name AS label, "" AS value, type FROM `repository_sql`
									WHERE repository_id = :repository');
		// + kroky?
		$stmt->execute(array(':repository' => $id));
		return $stmt->fetchAll();
	}

	public function getRepositories() {
		$stmt = $this->db->query('SELECT * FROM `repository` ORDER BY name ASC;');
		return $stmt->fetchAll();
	}

	public function getRules() {
		return array(
				array('id' => 'PRESNA_SHODA', 'name' => 'Přesná shoda řetězce'),
				array('id' => 'TOLERANCE_CASE', 'name' => 'Shoda s tolerancí - case insensitive'),
				array('id' => 'TOLERANCE_DIACRITIC', 'name' => 'Shoda s tolerancí - odstranění diakritiky'),
				array('id' => 'TOLERANCE_SUB', 'name' => 'Shoda podřetězce'),
			);
	}

	public function getHTMLElements($id, $contains = 0) {
		$stmt = $this->db->prepare('SELECT e.type, e.label AS value FROM `log_repository_elements` AS l
									LEFT JOIN `repository_html` AS e ON e.id = l.element_id
									WHERE l.log_id = ? AND l.element_type IN ("anchor", "input") 
									AND l.occurrences_in_script = ?;');
		$stmt->execute(array($id, $contains));
		return $stmt->fetchAll();
	}

	public function getSQLElements($id, $contains = 0) {
		$stmt = $this->db->prepare('SELECT e.type, e.name AS value FROM `log_repository_elements` AS l
									LEFT JOIN `repository_sql` AS e ON e.id = l.element_id
									WHERE l.log_id = ? AND l.element_type IN ("column", "table") 
									AND l.occurrences_in_script = ?;');
		$stmt->execute(array($id, $contains));
		return $stmt->fetchAll();
	}

	public function getScripts($id, $contains = 0) {
		$stmt = $this->db->prepare('SELECT s.* FROM `log_scripts` AS l
									LEFT JOIN `script` AS s ON s.id = l.script_id
									WHERE l.log_id = ? 
									AND l.contains_element = ?;');
		$stmt->execute(array($id, $contains));
		return $stmt->fetchAll();
	}

	public function findById($id) {

		$stmt = $this->db->prepare('SELECT l.*, s.name AS dir, r.name AS repository, DATE_FORMAT(date_of_comparison, "%d.%m. %H:%i") AS datef FROM `comparison_log` AS l 
									LEFT JOIN `repository` AS r ON r.id = l.repository_id
									LEFT JOIN `script_dir` AS s ON s.id = l.script_dir_id
									WHERE `l`.`id` = :id;');
		$stmt->execute(array(':id' => $id));
		//print_r($stmt->fetch());
		return $stmt->fetch();
	}

}

?>