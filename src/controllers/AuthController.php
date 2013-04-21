<?php

class AuthController extends Controller {

	public function __construct(AuthViewModel $model) {
		$this->model = $model;
	}

	public function login() {
		if(count($_POST))
			if($this->model->checkLogin($_POST)) {
				header('Location: /');
			}
	}

	public function register() {
		if(count($_POST))
			if($this->model->addUser($_POST)) {
				header('Location: /login');
			}
	}

	public function logout() {
		// info odhlasen
		session_destroy();
		header('Location: /');
		die();
	}

}

?>