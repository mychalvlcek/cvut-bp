<?php

class UserListView {
	private $model;
	private $template;

	public function __construct($route, Listable $model, Template $template) {
		$this->model = $model;
		$this->template = $template;
	}

	public function output() {
		$this->template->set('data', $this->model->getData()); 
		$this->template->setTemplate('list.html');
		return $this->template->output();
	}
}

?>