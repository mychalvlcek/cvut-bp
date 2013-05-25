<?php
/**
 * Abstract TOP-LEVEL model
 */
class ViewModel {
	protected $model;
	protected $sessionManager;

	public function __construct(Model $model, SessionManager $sessionManager) {
		$this->model = $model;
		$this->sessionManager = $sessionManager;
	}

	public function setSort($sort, $order) {
		$this->model->setSort($sort, $order);
	}

	public function setPage($page = 1) {
		$this->model->setPage($page);
	}

	public function getRecordsPerPage() {
		return $this->model->getRecordsPerPage();
	}


	public function addInfo($level, $message) {
		$this->sessionManager->add('messages', $level, $message);
	}
	public function getInfo($clear = 1) {
		$msgs = $this->sessionManager->get('messages');
		if($msgs == '') $msgs = array();
		if($clear)
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

	public function getMenu() {
		if($this->isAdmin())
		return array(
				array('title' => 'Načtení repozitáře', 'url' => 'repository/add', 'menuroute' => 'repository_add'),
				array('title' => 'Repozitáře', 'url' => 'repository/list', 'menuroute' => 'repository_list'),
				array('title' => 'Sady skriptů', 'url' => 'dir/list', 'menuroute' => 'dir_list'),
				array('title' => 'Uživatelé', 'url' => 'user/list', 'menuroute' => 'user_list'),
				array('title' => 'Logy', 'url' => 'log/list', 'menuroute' => 'log_list')
			);
		return array(
				array('title' => 'Načtení repozitáře', 'url' => 'repository/add', 'menuroute' => 'repository_add'),
				array('title' => 'Repozitáře', 'url' => 'repository/list', 'menuroute' => 'repository_list'),
				array('title' => 'Sady skriptů', 'url' => 'dir/list', 'menuroute' => 'dir_list'),
				array('title' => 'Logy', 'url' => 'log/list', 'menuroute' => 'log_list')
			);
	}
}

?>