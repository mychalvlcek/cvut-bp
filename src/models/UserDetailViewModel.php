<?php

class UserDetailViewModel extends ViewModel implements Detailable, Editable {
	private $id;
	
	public function __construct(UserModel $model) {
		$this->model = $model;
	}
	
	public function edit($data) {
		//return $this->model->update($data);
	}

	public function makeAdmin($id) {
		if($this->model->isAdmin() && $this->model->makeAdmin($id)) {
			$this->addInfo('info', 'Uživatel byl upraven');
		} else {
			$this->addInfo('error', 'Uživatele se nepodařilo upravit');
		}
		header('Location: /user/list/');
		die();
	}

	public function makeUser($id) {
		if($this->model->isAdmin() && $this->model->makeUser($id)) {
			$this->addInfo('info', 'Uživatel byl zbaven práv');
		} else {
			$this->addInfo('error', 'Uživatele se nepodařilo upravit');
		}
		header('Location: /user/list/');
		die();
	}

	public function delete($id) {
		if($this->model->isAdmin() && $this->model->delete($id)) {
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