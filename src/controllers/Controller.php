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

	private function isUserLogged() {
		return $this->model->isLogged();
	}

	public function getName() {
		return get_class($this);
	}
}

?>