<?php

class RegisterController extends Controller {

	public function __construct(AuthViewModel $model) {
		$this->model = $model;
	}

	public function login() {
		if($this->model->check($_POST)) {
			header('Location: /');
		}
	}

	public function process() {
		
	}

}

?>