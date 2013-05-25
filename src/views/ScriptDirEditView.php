<?php

class ScriptDirEditView extends View {

	public function __construct($route, Detailable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$detail = $this->model->getDetail();
		if($detail) {
			$this->template->addVariables($detail);
		} else {
			$this->template->setTemplate('error.html');
			$this->template->set('error', 'Složka nebyla nalezena.');
		}
		return $this->template->output();
	}
}

?>