<?php

class UserModel extends Model {
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

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
	
}

?>