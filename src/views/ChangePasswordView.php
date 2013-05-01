<?php

class ChangePasswordView extends View {

	public function __construct($route, ViewModel $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$this->template->set('html_title', 'Změna hesla');
		return $this->template->output();
	}
}

?>