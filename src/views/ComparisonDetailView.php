<?php

class ComparisonDetailView extends View {

	public function __construct($route, Detailable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$detail = $this->model->getDetail();
		if($detail) {
			$this->template->addVariables($detail);
			$this->template->set('contained_elements', $this->model->getContainedElements());
			$this->template->set('noncontained_elements', $this->model->getNonContainedElements());

			$this->template->set('occurrenced_scripts', $this->model->getOccurrencedScripts());
			$this->template->set('nonoccurrenced_scripts', $this->model->getNonOccurrencedScripts());
		} else {
			$this->template->setTemplate('error.html');
			$this->template->set('error', 'Log nebyl nalezen.');
		}
		return $this->template->output();
	}
}

?>