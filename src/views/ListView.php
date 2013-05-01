<?php

class ListView extends View {

	public function __construct($route, Listable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$this->template->set('html_title', $this->model->getEntityName());

		$data = $this->model->getData();
		$this->template->set('data', $data);
		if(!count($data)) {
			$this->template->set('noresults', 1);
		}
		return $this->template->output();
	}
}

?>