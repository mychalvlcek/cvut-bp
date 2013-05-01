<?php
/**
 * Abstract TOP-LEVEL model
 */
class ViewModel {
	protected $model;
	private $requestData;

	public function __construct(Model $model) {
		$this->model = $model;
	}

	public function getAllRecordsCount($table) {
		return $this->model->getAllRecordsCount($table);
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
		$this->model->addInfo($level, $message);
	}

	public function getInfo() {
		return $this->model->getInfo();
	}

	public function getPostData() {
		return $this->model->getPostData();
	}

	public function setSession($key = '', $value = '') {
		$this->model->setSession($key, $value);
	}

	public function getUser() {
		return $this->model->getUser();
	}

	public function isLogged() {
		return $this->model->isLogged();
	}

	public function isAdmin() {
		return $this->model->isAdmin();
	}

	public function getMenu() {
		if($this->isAdmin())
		return array(
				array('title' => 'Načtení repozitáře', 'url' => 'repository/add', 'menuroute' => 'repository_add'),
				array('title' => 'Repozitáře', 'url' => 'repository/list', 'menuroute' => 'repository_list'),
				array('title' => 'Testovací skripty', 'url' => 'script/list', 'menuroute' => 'script_list'),
				array('title' => 'Pravidla', 'url' => 'rule/list', 'menuroute' => 'rule_list'),
				array('title' => 'Uživatelé', 'url' => 'user/list', 'menuroute' => 'user_list'),
				array('title' => 'Logy', 'url' => 'log/list', 'menuroute' => 'log_list')
			);
		return array(
				array('title' => 'Načtení repozitáře', 'url' => 'repository/add', 'menuroute' => 'repository_add'),
				array('title' => 'Repozitáře', 'url' => 'repository/list', 'menuroute' => 'repository_list'),
				array('title' => 'Testovací skripty', 'url' => 'script/list', 'menuroute' => 'script_list'),
				array('title' => 'Pravidla', 'url' => 'rule/list', 'menuroute' => 'rule_list'),
				array('title' => 'Logy', 'url' => 'log/list', 'menuroute' => 'log_list')
			);
	}
}

?>