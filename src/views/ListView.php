<?php

class ListView extends View {

	public function __construct($route, Listable $model, Template $template) {
		$this->route = $route;
		$this->model = $model;
		$this->template = $template;
	}

	public function output() {
		$this->template->set('html_title', $this->model->getEntityName());
		$this->template->set('data', $this->model->getData());
		//$this->template->set('criterium', $this->model->getCriteria());
		return $this->template->output();
	}
}

?>