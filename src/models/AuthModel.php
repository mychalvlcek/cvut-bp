<?php

class AuthModel extends Model {
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

	public function createUser($data) {
		$data['salt'] = sha1(time());
		$data['password'] = sha1($data['password'].$data['salt']);
		$stmt = $this->db->prepare("INSERT INTO `users` (email, username, password, salt) VALUES(:email,:username,:password,:salt)"); 
		$stmt->execute(array(':email' => $data['email'], ':username' => $data['username'], ':password' => $data['password'], ':salt' => $data['salt']));
		return $this->db->lastInsertId();
	}

	public function findUser($username, $password) {
		$stmt = $this->db->prepare("SELECT id, email, username, is_admin FROM `users` WHERE username = :username AND password = SHA1(CONCAT(:password, salt));");
		$stmt->execute(array(':username' => $username, ':password' => $password));
		return $stmt->fetchAll();
	}

	public function userExists($email = '') {
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE email = :email;");
		$stmt->execute(array(':email' => $email));
		return $stmt->rowCount();
	}
	
}

?>