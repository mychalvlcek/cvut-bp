<?php
/**
 * Abstract TOP-LEVEL model
 */
class Model {
	protected $db;
	protected static $sessionManager;
	protected $perPage = 5;
	protected $page = 1;
	protected $sort = 'id';
	protected $sortOrder = 'DESC';
	protected $where = array(':id' => 1);

	public function __construct(PDO $db, SessionManager $sessionManager) {
		$this->db = $db;
		$this->sessionManager = $sessionManager;
	}


	public function getAll($table, $limit = '') {
		$stmt = $this->db->query('SELECT * FROM `'.$table.'` ORDER BY '.$this->sort.' '.$this->sortOrder.' '.$this->getLimitString($limit).';');
		return $stmt->fetchAll();
	}

	public function getRecordsCount($table) {
		$stmt = $this->db->query('SELECT COUNT(*) FROM `'.$table.'` ;');
		$row = $stmt->fetch(PDO::FETCH_NUM);
		return $row[0];
	}

	public function getRecordsCountWhere($table, $where = '') {
		$stmt = $this->db->query('SELECT COUNT(*) FROM `'.$table.'` WHERE repository_id = '.$where.';');
		$row = $stmt->fetch(PDO::FETCH_NUM);
		return $row[0];
	}

	public function getAllByAuthor($table, $author, $limit = 0) {
		$stmt = $this->db->prepare('SELECT * 
									FROM `'.$table.'` 
									WHERE `author` = :author
									ORDER BY '.$this->sort.' '.$this->sortOrder.';');
		$stmt->execute(array(':author' => $author));
		return $stmt->fetchAll();
	}

	public function findById($table, $id) {
		$stmt = $this->db->prepare("SELECT * FROM `$table` WHERE `id` = :id LIMIT 1;");
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch();
	}

	public function delete($table, $id) {
		$stmt = $this->db->prepare('DELETE FROM `$table` WHERE id = :id');
		$result = $stmt->execute(array(':id' => $id));
		return $stmt && $result ? $stmt->rowCount() : false;
	}

	protected function getLimitString($limit = '') {
		if($limit != '') {
			$limit = 'LIMIT '.($this->page-1)*$this->perPage.', '.$this->perPage;
		}
		return $limit;
	}




	public function setSort($sort = 'id', $sortOrder = 'DESC') {
		$this->sort = $sort;
		$this->sortOrder = $sortOrder;
	}

	public function setPage($page = 1) {
		$this->page = $page;
	}

	public function getPage() {
		return $this->page;
	}

	public function getRecordsPerPage() {
		return $this->perPage;
	}


	public function addInfo($level, $message) {
		$this->sessionManager->add('messages', $level, $message);
	}
	public function getInfo() {
		$msgs = $this->sessionManager->get('messages');
		if($msgs == '') $msgs = array();
		$this->sessionManager->clear('messages');
		return $msgs;
	}


	public function getUser() {
		$user = $this->sessionManager->get('user');
		if(is_array($user)) return (object) $user;
		return $user;
	}

	public function isAdmin() {
		$user = $this->getUser();
		return ($user && $user->is_admin?$user->is_admin:false);
	}

	public function isLogged() {
		return ($this->getUser()?true:false);
	}

	public function setSession($key = '', $value = '') {
		$this->sessionManager->set($key, $value);
	}

	public function getPostData() {
		return $_POST;
	}

	public function setSessionData($data = array()) {
		$_SESSION['user'] = $data;
	}

}

?>