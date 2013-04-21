<?php

class RepositoryModel extends Model {
	
	public function __construct(PDO $db) {
		$this->db = $db;
	}

	public function processUrl($url) {
		if($url != '') {
			$file = file_get_contents(trim($url));
			if ( preg_match_all('#<a[^>]*>([^<]*)<\/a>#i', $file, $matches) ) {
				//$anchors = implode(', ', $matches[0]);
			}
			//$file = htmlspecialchars(file_get_contents(trim($url)));
		}
	}

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
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function delete($id) {
		$stmt = $this->db->prepare('DELETE FROM `repository` WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	public function getAllByAuthor($author) {
		$stmt = $this->db->prepare('SELECT *, DATE_FORMAT(date_of_creation, "%d.%m. %H:%i") AS datef 
									FROM `repository` 
									WHERE `author` = :author
									ORDER BY '.$this->sort.' '.$this->sortOrder.';');
		$stmt->execute(array(':author' => $author));
		return $stmt->fetchAll();
	}

	public function findById($id) {
		$stmt = $this->db->prepare("SELECT * FROM `repository` WHERE `id` = :id LIMIT 1;");
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch();
	}

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