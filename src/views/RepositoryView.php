<?php

class RepositoryView extends View {
	
	public function __construct($route, ViewModel $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		return $this->template->output();
	}
}

?>