<?php

class UserController extends Controller { 
	private $model;

	public function __construct(UserListViewModel $model) {
		$this->model = $model;
	}

	public function search() {
		$this->model->setCriteria('David');
	}

}

?>