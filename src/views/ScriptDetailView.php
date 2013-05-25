<?php

class ScriptDetailView extends View {

	public function __construct($route, Detailable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$detail = $this->model->getDetail();
		if($detail) {
			$this->template->addVariables($detail);
			$this->template->set('steps', $this->model->getScriptSteps());
		} else {
			$this->template->setTemplate('error.html');
			$this->template->set('error', 'Repozitář nebyl nalezen.');
		}
		return $this->template->output();
	}
}

?>