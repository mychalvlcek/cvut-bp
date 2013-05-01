<?php

class RepositoryDetailView extends View {

	public function __construct($route, Detailable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$detail = $this->model->getDetail();
		if($detail) {
			$this->template->addVariables($detail);
			$this->template->set('sql_elements', $this->model->getSQLElements());
			$this->template->set('html_elements', $this->model->getHTMLElements());
		} else {
			$this->template->setTemplate('error.html');
			$this->template->set('error', 'Repozitář nebyl nalezen.');
		}
		return $this->template->output();
	}
}

?>