<?php

class UserModel extends Model {
	
	public function getAll() {
		$stmt = $this->db->query("SELECT *, DATE_FORMAT(date_of_creation, '%d.%m. %H:%i') AS datef FROM `users`;");
		return $stmt->fetchAll();
	}

	public function findById($id) {
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `id` = :id LIMIT 1;");
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch();
	}

	public function findByName($name) {
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `username` LIKE :name;");
		$stmt->execute(array(':name' => $name));
		return $stmt->fetchAll();
	}

	public function makeAdmin($id) {
		$stmt = $this->db->prepare('UPDATE `users` SET is_admin = 1 WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function makeUser($id) {
		$stmt = $this->db->prepare('UPDATE `users` SET is_admin = 0 WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function delete($id) {
		$stmt = $this->db->prepare('DELETE FROM `users` WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}
	
}

?>