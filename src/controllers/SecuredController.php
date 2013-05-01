<?php

abstract class SecuredController extends Controller {
	protected $model;

	public function __construct(ViewModel $model) {
		$this->model = $model;
		if ( !$this->isUserAdmin() ) {
			header('Location: /error/auth/');
			die();
		}
	}

	private function isUserAdmin() {
		return $this->model->isAdmin();
	}
}

?>