<?php

class HomeView extends View {

	public function __construct($route, Model $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$this->template->setTemplate('home.html');
		$this->template->set('anchors', $this->model->getAnchors());
		$this->template->set('file', $this->model->getFile());
		return $this->template->output();
	}
}

?>