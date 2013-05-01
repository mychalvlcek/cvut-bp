<?php

class ErrorViewModel extends ViewModel {
	private $msg;
	
	public function __construct(Model $model) {
		$this->model = $model;
		$this->msg = 'Požadovaná stránka nebyla nalezena.';
	}

	public function setMessage($msg) {
		$this->msg = $msg;
	}

	public function getMessage() {
		return $this->msg;
	}
}

?>