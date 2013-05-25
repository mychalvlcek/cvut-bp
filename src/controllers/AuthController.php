<?php

class AuthController extends Controller {

	public function __construct(AuthViewModel $model) {
		$this->model = $model;
	}

	public function login() {
		if ( $this->isUserLogged() ) {
			header('Location: /');
			die();
		}
		if(count($_POST))
			if($this->model->checkLogin($_POST)) {
				header('Location: /');
				die();
			}
	}

	public function register() {
		if ( $this->isUserLogged() ) {
			header('Location: /');
			die();
		}
		if(count($_POST))
			if($this->model->registerUser($_POST)) {
				header('Location: /login');
				die();
			}
	}

	public function password() {
		if(count($_POST))
			$this->model->changePassword($_POST);
	}

	public function logout() {
		session_destroy();
		header('Location: /');
		die();
	}

}

?>