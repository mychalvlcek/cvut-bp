<?php

class RepositoryModel extends Model {

	public function insert($data) {
		$stmt = $this->db->prepare('INSERT INTO `repository` (name, author) VALUES (:name, :author)');
		$result = $stmt->execute(array(':name' => $data['name'], ':author' => $data['author']));
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	public function update($id, $data) {
		$stmt = $this->db->prepare('UPDATE `repository` SET name = :name WHERE id = :id');
		$result = $stmt->execute(array(':name' => $data['name'], ':id' => $id));
		return $stmt && $result ? true : false;
	}
	
	public function insertSqlArtefacts($data) {
		$stmt = $this->db->prepare('INSERT INTO `repository_sql` (name, type, repository_id) VALUES (:name, :type, :repository_id)');
		//$result = $stmt->execute(array(':name' => $data['name'], ':type' => $data['type'], ':repository_id' => $data['repository_id']));
		$result = $stmt->execute($data);
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	public function insertHTMLElements($data) {
		$stmt = $this->db->prepare('INSERT INTO `repository_html` (label, value, type, repository_id) VALUES (:label, :value, :type, :repository_id)');
		$result = $stmt->execute($data);
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	public function delete($id) {
		try {
			$stmt = $this->db->prepare('DELETE FROM `repository` WHERE id = :id');
			$result = $stmt->execute(array(':id' => $id));
			// AFTER DELETE trigger
			if($stmt && $result) {
				$trgrstmt = $this->db->prepare('DELETE FROM `repository_sql` WHERE repository_id = :id');
				$result = $trgrstmt->execute(array(':id' => $id));
				$trgrstmt = $this->db->prepare('DELETE FROM `repository_html` WHERE repository_id = :id');
				$result = $trgrstmt->execute(array(':id' => $id));
			}
			return $stmt && $result ? $stmt->rowCount() : false;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function clear($id) {
		try {
			$stmt = $this->db->prepare('DELETE FROM `repository_sql` WHERE repository_id = :id');
			$result = $stmt->execute(array(':id' => $id));
			$stmt = $this->db->prepare('DELETE FROM `repository_html` WHERE repository_id = :id');
			$result = $stmt->execute(array(':id' => $id));
			return $stmt && $result ? true : false;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function getRepositoryByElement($id) {
		$stmt = $this->db->prepare('SELECT repository_id FROM `repository_html` WHERE id = :id;');
		$stmt->execute(array(':id' => $id));
		return $stmt->fetchColumn();
	}

	public function deleteElement($id) {
		try {
			$stmt = $this->db->prepare('DELETE FROM `repository_html` WHERE id = :id');
			$result = $stmt->execute(array(':id' => $id));
			return $stmt && $result ? true : false;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function getAll() {
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
									ORDER BY '.$this->sort.' '.$this->sortOrder.' '.$this->getLimitString().';');
		return $stmt->fetchAll();
	}

	public function findByName($name) {
		$stmt = $this->db->prepare('SELECT *, DATE_FORMAT(date_of_creation, "%d.%m. %H:%i") AS datef FROM `repository` AS r 
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
									WHERE `name` LIKE :name
									ORDER BY '.$this->sort.' '.$this->sortOrder.' '.$this->getLimitString().';');
		$stmt->execute(array(':name' => '%'.$name.'%'));
		return $stmt->fetchAll();
	}

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
									WHERE `repository_id` = :id;");
		$stmt->execute(array(':id' => $repositoryId));
		return $stmt->fetchAll();
	}

	public function getAllCount() {
		return $this->db->query('SELECT COUNT(*) FROM `repository`;')->fetchColumn();
	}

	public function findByAuthorCount($author) {
		$stmt = $this->db->prepare('SELECT COUNT(*) FROM `repository` 
									WHERE `author` = :author;');
		$stmt->execute(array(':author' => $author));
		return $stmt->fetchColumn();
	}

	public function findByNameCount($name) {
		$stmt = $this->db->prepare('SELECT COUNT(*) FROM `repository` 
									WHERE `name` LIKE :name ;');
		$stmt->execute(array(':name' => '%'.$name.'%'));
		return $stmt->fetchColumn();
	}

	public function findByNameAndAuthorCount($author, $name) {
		$stmt = $this->db->prepare('SELECT COUNT(*) FROM `repository` 
									WHERE `name` LIKE :name 
									AND `author` = :author;');
		$stmt->execute(array(':name' => '%'.$name.'%', ':author' => $author));
		return $stmt->fetchColumn();
	}
	
}

?>