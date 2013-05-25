<?php

abstract class Controller {
	protected $model;

	public function __construct(ViewModel $model) {
		$this->model = $model;
		if ( !$this->isUserLogged() ) {
			header('Location: /auth/login');
			die();
		}
	}

	protected function isUserLogged() {
		return $this->model->isLogged();
	}
}

?>