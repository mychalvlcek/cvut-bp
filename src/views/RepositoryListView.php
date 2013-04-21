<?php

class RepositoryListView extends View {

	public function __construct($route, Listable $model, Template $template) {
		$this->route = $route;
		$this->model = $model;
		$this->template = $template;
	}

	public function output() {
		$this->template->set('html_title', $this->model->getEntityName());
		$data = $this->model->getData();
		$this->template->set('data', $data);
		if(!count($data)) {
			$this->template->set('noresults', 1);
		}
		$criterium = $this->model->getCriteria();
		if($criterium != '') {
			$this->template->set('criterium', $criterium);
		}
		return $this->template->output();
	}
}

?>