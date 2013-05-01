<?php

class RepositoryModel extends Model {

	public function save($data) {
		if(isset($data['id'])) {
			//$this->update();
		} else {
			//$this->insert();
		}
	}

	public function insert($data) {
		$stmt = $this->db->prepare('INSERT INTO `repository` (name, author) VALUES (:name, :author)');
		$result = $stmt->execute(array(':name' => $data['name'], ':author' => $data['author']));
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	//http://stackoverflow.com/questions/1176352/pdo-prepared-inserts-multiple-rows-in-single-query
	public function insertSqlArtefactsNew($id, $data) {
		$this->db->beginTransaction();
		foreach($data as $d) {
			$questionMarks[] = '(?, \'table\', '.$id.')';
		}

		$sql = 'INSERT INTO `repository_sql` (name, type, repository_id) VALUES ' . implode(',', $questionMarks);
		echo $sql;
		die();

		$stmt = $this->db->prepare($sql);
    	$stmt->execute($values);
		$this->db->commit();

		$stmt = $this->db->prepare('INSERT INTO `repository_sql` (name, type, repository_id) VALUES (?,?,?)');
		$stmt->execute($data);
		return $this->db->commit();
	}
	public function insertSqlArtefacts($data) {
		$stmt = $this->db->prepare('INSERT INTO `repository_sql` (name, type, repository_id) VALUES (:name, :type, :repository_id)');
		//$result = $stmt->execute(array(':name' => $data['name'], ':type' => $data['type'], ':repository_id' => $data['repository_id']));
		$result = $stmt->execute($data);
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	public function delete($id) {
		$stmt = $this->db->prepare('DELETE FROM `repository` WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		// ON DELETE trigger
		if($stmt && $result) {
			$trgrstmt = $this->db->prepare('DELETE FROM `repository_sql` WHERE repository_id = :id');
			$result = $trgrstmt->execute(array(':id' => $id));
		}
		return $stmt && $result ? $stmt->rowCount() : false;
	}
	// all records - admin
	public function getAll($limit = '') {
		$stmt = $this->db->query('SELECT *, DATE_FORMAT(date_of_creation, "%d.%m. %H:%i") AS datef FROM `repository` AS r 
									LEFT JOIN (
										SELECT repository_id, COUNT(*) AS sql_pocet FROM repository_sql 
										GROUP BY repository_id
										) AS s 
									ON r.id = s.repository_id 
									LEFT JOIN (
										SELECT repository_id, COUNT(*) AS html_pocet FROM repository_html 
										GROUP BY repository_id
										) AS h 
									ON r.id = h.repository_id 
									ORDER BY '.$this->sort.' '.$this->sortOrder.' '.$this->getLimitString($limit).';');
		return $stmt->fetchAll();
	}

	
	// all by author
	public function getAllByAuthor($author) {
		$stmt = $this->db->prepare('SELECT *, DATE_FORMAT(date_of_creation, "%d.%m. %H:%i") AS datef 
									FROM `repository` 
									WHERE `author` = :author
									ORDER BY '.$this->sort.' '.$this->sortOrder.';');
		$stmt->execute(array(':author' => $author));
		return $stmt->fetchAll();
	}
	// detail
	public function findById($id) {
		$stmt = $this->db->prepare('SELECT *, DATE_FORMAT(date_of_creation, "%d.%m.%Y %H:%i") AS date_of_creation FROM `repository` AS r 
									LEFT JOIN (
										SELECT repository_id, COUNT(*) AS sql_pocet FROM repository_sql 
										GROUP BY repository_id
										) AS s 
									ON r.id = s.repository_id 
									LEFT JOIN (
										SELECT repository_id, COUNT(*) AS html_pocet FROM repository_html 
										GROUP BY repository_id
										) AS h 
									ON r.id = h.repository_id 
									WHERE `id` = :id LIMIT 1;');
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch();
	}
	// elements
	public function findRepositoryElements($repositoryId, $type = 'sql') {
		$stmt = $this->db->prepare("SELECT * 
									FROM `repository_{$type}` 
									WHERE `repository_id` LIKE :id;");
		$stmt->execute(array(':id' => $repositoryId));
		return $stmt->fetchAll();
	}

	// filter
	public function findByName($name) {
		$stmt = $this->db->prepare('SELECT *, DATE_FORMAT(date_of_creation, "%d.%m. %H:%i") AS datef 
									FROM `repository` 
									WHERE `name` LIKE :name
									ORDER BY '.$this->sort.' '.$this->sortOrder.';');
		$stmt->execute(array(':name' => $name));
		return $stmt->fetchAll();
	}
	
}

?>