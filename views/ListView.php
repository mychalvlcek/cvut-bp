<?php

class ListView {
	private $model;
	private $template;

	public function __construct($route, Listable $model, Template $template) {
		$this->model = $model;
		$this->template = $template;
	}

	public function output() {
		$this->template->set('data', $this->model->getData()); 
		return $this->template->output();
	}
}

?>