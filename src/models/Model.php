<?php
/**
 * Abstract TOP-LEVEL model
 */
class Model {
	protected $db;
	protected static $infoMessages = array();
	//SessionManager.class
	//protected static $sessionManager;
	protected $sort = 'id';
	protected $sortOrder = 'DESC';


	public function getAll($table) {
		//$stmt = $this->db->query('SELECT * , DATE_FORMAT(date_of_creation, "%d.%m. %H:%i") AS datef FROM `'.$table.'` ORDER BY '.$this->sort.' '.$this->sortOrder.';');
		$stmt = $this->db->query('SELECT * FROM `'.$table.'` ORDER BY '.$this->sort.' '.$this->sortOrder.';');
		return $stmt->fetchAll();
	}

	public function findById($table, $id) {
		$stmt = $this->db->prepare("SELECT * FROM `$table` WHERE `id` = :id LIMIT 1;");
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch();
	}

	public function setSort($sort = 'id', $sortOrder = 'DESC') {
		$this->sort = $sort;
		$this->sortOrder = $sortOrder;
	}

	public function addInfo($level, $message) {
		self::$infoMessages[$level][] = $message;
	}
	// getMessages
	public function getInfo() {
		return self::$infoMessages;
	}

	public function getPostData() {
		return $_POST;
	}

	public function userName() {
		return (isset($_SESSION['user']['username'])?$_SESSION['user']['username']:'');
	}

	public function setSessionData($data = array()) {
		//foreach($data as $key => $value)
			//$_SESSION[$key] = $value;
		$_SESSION['user'] = $data;
	}

	public function getLoggedUserId() {
		return (isset($_SESSION['user']['id'])?$_SESSION['user']['id']:0);
	}

	public function isLoggedUserAdmin() {
		return (isset($_SESSION['user']['is_admin'])?$_SESSION['user']['is_admin']:false);
	}

	public function isUserLogged() {
		return (isset($_SESSION['user'])?true:false);
	}

	public function getMenu() {
		return array(
				array('title' => 'Načtení repozitáře', 'url' => 'repository/add', 'menuroute' => 'repository_add'),
				array('title' => 'Repozitáře', 'url' => 'repository/list', 'menuroute' => 'repository_list'),
				array('title' => 'Testovací skripty', 'url' => 'script/list', 'menuroute' => 'script_list'),
				array('title' => 'Pravidla', 'url' => 'rule/list', 'menuroute' => 'rule_list'),
				array('title' => 'Uživatelé', 'url' => 'user/list', 'menuroute' => 'user_list'),
				array('title' => 'Logy', 'url' => 'log/list', 'menuroute' => 'log_list')
			);
	}
}

?>