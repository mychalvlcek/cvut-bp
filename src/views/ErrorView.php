<?php

class ErrorView extends View {

	public function __construct($route, ErrorViewModel $model, Template $template) {
		parent::__construct($route, $model, $template);
	}
	
	public function output() {
		$this->template->set('error', $this->model->getMessage());
		$this->template->setTemplate('error.html');
		return $this->template->output();
	}
}

?>