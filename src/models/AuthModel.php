<?php

class AuthModel extends Model {

	public function createUser($data) {
		$data['salt'] = sha1(time());
		$data['password'] = sha1($data['password'].$data['salt']);
		$stmt = $this->db->prepare("INSERT INTO `users` (email, username, password, salt) VALUES(:email,:username,:password,:salt)"); 
		$stmt->execute(array(':email' => $data['email'], ':username' => $data['username'], ':password' => $data['password'], ':salt' => $data['salt']));
		return $this->db->lastInsertId();
	}

	public function changePassword($data) {
		$stmt = $this->db->prepare("UPDATE users SET password = SHA1(CONCAT(:password, salt)) WHERE id = :id AND password = SHA1(CONCAT(:old_password, salt))"); 
		$stmt->execute(array(':id' => $data['id'], ':old_password' => $data['old_password'], ':password' => $data['password']));
		return $stmt->rowCount();
	}

	public function findUser($username, $password) {
		$stmt = $this->db->prepare("SELECT id, email, username, is_admin FROM `users` WHERE username = :username AND password = SHA1(CONCAT(:password, salt));");
		$stmt->execute(array(':username' => $username, ':password' => $password));
		return $stmt->fetchAll();
	}

	public function userExists($email = '', $username) {
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE email = :email OR username = :username;");
		$stmt->execute(array(':email' => $email, ':username' => $username));
		return $stmt->rowCount();
	}

	public function checkUserPassword($id = '', $password = '') {
		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE id = :id AND password = SHA1(CONCAT(:password, salt))"); 
		$stmt->execute(array('id' => $id, ':password' => $password));
		return $stmt->rowCount();
	}
	
}

?>