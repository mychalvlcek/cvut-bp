<?php

class UserController extends SecuredController { 

	public function __construct(ViewModel $model) {
		parent::__construct($model);
	}

	public function lst() {
		if(isset($_GET['criterium'])) {
			$this->search($_GET['criterium']);
		}
	}

	public function search($criterium) {
		$this->model->setCriteria($criterium);
	}

	public function makeadmin($id = 0) {
			$this->model->makeAdmin($id);
	}

	public function makeuser($id = 0) {
			$this->model->makeUser($id);
	}

	public function delete($id = 0) {
			$this->model->delete($id);
	}

	public function show($id = 0) {
		$this->model->setId($id);
	}

}

?>