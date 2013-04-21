<?php

class RepositoryView extends View {
	public function __construct($route, ViewModel $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		//$this->template->setTemplate('repository_new.html');
		return $this->template->output();
	}
}

?>