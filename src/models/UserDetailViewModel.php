<?php

class UserDetailViewModel extends ViewModel implements Detailable {
	private $id;
	
	public function __construct(UserModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}

	public function makeAdmin($id) {
		if($this->isAdmin() && $this->model->makeAdmin($id)) {
			$this->addInfo('info', 'Uživatel byl upraven');
		} else {
			$this->addInfo('error', 'Uživatele se nepodařilo upravit');
		}
		header('Location: /user/list/');
		die();
	}

	public function makeUser($id) {
		if($this->isAdmin() && $this->model->makeUser($id)) {
			$this->addInfo('info', 'Uživatel byl zbaven práv');
		} else {
			$this->addInfo('error', 'Uživatele se nepodařilo upravit');
		}
		header('Location: /user/list/');
		die();
	}

	public function delete($id) {
		if($this->isAdmin() && $this->model->delete($id)) {
			$this->addInfo('info', 'Uživatel byl smazán');
		} else {
			$this->addInfo('error', 'Uživatele se nepodařilo smazat');
		}
		header('Location: /user/list/');
		die();
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getDetail() {
		return $this->model->findById($this->id);
	}
}

?>