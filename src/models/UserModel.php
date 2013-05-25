<?php
/**
 * Model for User entity
 * Provides basic operations.
 */
class UserModel extends Model {
	
	/**
	 * Gets all users
	 */
	public function getAll() {
		$stmt = $this->db->query("SELECT *, DATE_FORMAT(date_of_creation, '%d.%m. %H:%i') AS datef FROM `users`
								ORDER BY ".$this->sort." ".$this->sortOrder." ".$this->getLimitString().';');
		return $stmt->fetchAll();
	}
	/**
	 * Gets count of all users
	 */
	public function getAllCount() {
		return $this->db->query('SELECT COUNT(*) FROM `users`;')->fetchColumn();
	}
	/**
	 * Get user specified by ID
	 */
	public function findById($id) {
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `id` = :id LIMIT 1;");
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch();
	}
	/**
	 * Gets all users by name
	 */
	public function findByName($name) {
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `username` LIKE :name;");
		$stmt->execute(array(':name' => '%'.$name.'%'));
		return $stmt->fetchAll();
	}
	/**
	 * Gets count of all users specified by name
	 */
	public function findByNameCount($name) {
		$stmt = $this->db->prepare('SELECT COUNT(*) FROM `users` 
									WHERE `name` LIKE :name;');
		$stmt->execute(array(':name' => $name));
		return $stmt->fetchColumn();
	}
	/**
	 * Grant privilegies
	 */
	public function makeAdmin($id) {
		$stmt = $this->db->prepare('UPDATE `users` SET is_admin = 1 WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}
	/**
	 * Revoke privilegies
	 */
	public function makeUser($id) {
		$stmt = $this->db->prepare('UPDATE `users` SET is_admin = 0 WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}
	/**
	 * Drop specified user
	 */
	public function delete($id) {
		$stmt = $this->db->prepare('DELETE FROM `users` WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}
	
}

?>