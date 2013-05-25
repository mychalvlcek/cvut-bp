<?php

class SearchableListView extends View {

	public function __construct($route, Listable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$this->template->set('html_title', $this->model->getEntityName());
		$this->template->set('criterium', $this->model->getCriteria());

		$data = $this->model->getData();
		$this->template->set('data', $data);
		if(!count($data)) {
			$this->template->set('noresults', 1);
		}

		return $this->template->output();
	}
}

?>