<?php

class ScriptModel extends Model {
	
	public function getAll() {
		$stmt = $this->db->query("SELECT * FROM `script` ORDER BY id DESC;");
		return $stmt->fetchAll();
	}

	public function findById($id) {
		$stmt = $this->db->prepare("SELECT s.*, d.name AS directory FROM `script` AS s
									LEFT JOIN `script_dir` AS d
									ON `d`.`id` = `s`.`dir_id`
									WHERE `s`.`id` = :id 
									LIMIT 1;");

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

	public function update($id, $data) {
		$stmt = $this->db->prepare('UPDATE `script` SET '.$this->fields($data).' WHERE `id` = ?;');
		$data['id'] = $id;
		$result = $stmt->execute(array_values($data));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function delete($id) {
		$stmt = $this->db->prepare('DELETE FROM `script` WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		if($stmt && $result) {
			$trgrstmt = $this->db->prepare('DELETE FROM `script_step` WHERE script = :id');
			$result = $trgrstmt->execute(array(':id' => $id));
		}
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function findScriptSteps($id) {
		$stmt = $this->db->prepare("SELECT s.*, (@position := @position + 1) AS position FROM `script_step` AS s
			INNER JOIN ( SELECT @position := 0 ) AS v
			WHERE `script` = :id;");
		$stmt->execute(array(':id' => $id));
		return $stmt->fetchAll();
	}

	public function getScriptDirs() {
		$stmt = $this->db->query('SELECT * FROM `script_dir`;');
		return $stmt->fetchAll();
	}
	
}

?>