<?php

class UserController extends Controller { 

	public function __construct(UserViewModel $model) {
		parent::__construct($model);
	}

	public function delete($id = 1) {
		echo 'delete';
	}

	public function show($id = 1) {
		$this->model->setCriteria($id);
	}

}

?>