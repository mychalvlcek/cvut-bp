<?php
/**
 * Abstract TOP-LEVEL model
 */
class ViewModel {
	protected $model;

	public function __construct(Model $model) {
		$this->model = $model;
	}

	public function setSort($sort, $order) {
		$this->model->setSort($sort, $order);
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

	public function userName() {
		return $this->model->userName();
	}

	public function setSessionData($data = array()) {
		return $this->model->setSessionData($data);
	}

	public function getLoggedUserId() {
		return $this->model->getLoggedUserId();
	}

	public function isUserLogged() {
		return $this->model->isUserLogged();
	}

	public function getMenu() {
		return $this->model->getMenu();
	}
}

?>