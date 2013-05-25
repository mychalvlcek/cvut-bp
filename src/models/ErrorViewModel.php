<?php

class ErrorViewModel extends ViewModel {
	private $msg;
	
	public function __construct(Model $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
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