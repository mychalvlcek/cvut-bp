<?php

class ScriptModel extends Model {
	
	public function getAll() {
		$stmt = $this->db->query("SELECT * FROM `script` ORDER BY id DESC;");
		return $stmt->fetchAll();
	}

	public function findById($id) {
		$stmt = $this->db->prepare("SELECT * FROM `script` WHERE `id` = :id LIMIT 1;");
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch();
	}

	public function findByAuthor($author) {
		$stmt = $this->db->prepare("SELECT * FROM `script`
									 WHERE `author` = :author
									 ORDER BY id DESC;");
		$stmt->execute(array(':author' => $author));
		return $stmt->fetch();
	}

	public function update($data) {
		$stmt = $this->db->prepare('UPDATE `script` SET title = ?, description = ? ;');
		$result = $stmt->execute(array($data['title'], $data['description']));
		return $stmt && $result ? $stmt->rowCount() : false;
		/*
		$select_posts=$dbh->prepare("UPDATE activiteiten SET naam= ?  where id= ?");
		$select->execute(array($id, $naam));
		*/
	}
	
}

?>