<?php

class ScriptDirModel extends Model {
	
	public function getAll() {
		$stmt = $this->db->query('SELECT * FROM `script_dir` AS d 
									LEFT JOIN (
										SELECT dir_id, COUNT(*) AS count FROM `script` 
										GROUP BY dir_id
										) AS s 
									ON d.id = s.dir_id
									ORDER BY '.$this->sort.' '.$this->sortOrder.' '.$this->getLimitString().';');
		return $stmt->fetchAll();
	}

	public function getAllCount() {
		return $this->db->query('SELECT COUNT(*) FROM `script_dir`;')->fetchColumn();
	}

	public function findById($id) {
		$stmt = $this->db->prepare("SELECT * FROM `script_dir` WHERE `id` = :id LIMIT 1;");
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch();
	}

	public function findDirectoryScripts($dirId) {
		$stmt = $this->db->prepare("SELECT * FROM `script` AS s
									LEFT JOIN (
										SELECT script, COUNT(*) AS count FROM `script_step` 
										GROUP BY script
										) AS st 
									ON s.id = st.script
									WHERE `dir_id` = :id;");
		$stmt->execute(array(':id' => $dirId));
		return $stmt->fetchAll();
	}

	public function insert($name, $author) {
		$stmt = $this->db->prepare('INSERT INTO `script_dir` (name, author) VALUES (:name, :author)');
		$result = $stmt->execute(array(':name' => $name, ':author' => $author));
		return $stmt && $result ? $this->db->lastInsertId() : false;
	}

	public function update($id, $name) {
		$stmt = $this->db->prepare('UPDATE `script_dir` SET `name` = ? WHERE `id` = ?;');
		$result = $stmt->execute(array($name, $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function delete($id) {
		$stmt = $this->db->prepare('DELETE FROM `script_dir` WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		// ON DELETE trigger
		if($stmt && $result) {
			$trgrstmt = $this->db->prepare('UPDATE `script` SET `dir_id` = 1 WHERE dir_id = :id');
			$result = $trgrstmt->execute(array(':id' => $id));
		}
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function move($scripts, $id) {
		$stmt = $this->db->prepare("UPDATE `script` SET `dir_id` = ? WHERE `id` IN ('".join("', '", $scripts)."');");
		$result = $stmt->execute(array($id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	
}

?>