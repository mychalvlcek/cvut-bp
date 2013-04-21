<?php

class UserDetailController extends Controller { 

	public function __construct(UserDetailViewModel $model) {
		parent::__construct($model);
	}

	public function show($id = 0) {
		$this->model->setId($id);
	}

}

?>