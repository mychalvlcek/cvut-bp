<?php

class AuthView extends View {

	public function __construct($route, AuthViewModel $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		if($this->route == 'auth_login') {
			$this->template->set('html_title', 'Přihlášení');
		} else {
			$this->template->set('html_title', 'Registrace');
		}
		$this->template->addVariables($this->model->getPostData());
		return $this->template->output(false);
	}
}

?>