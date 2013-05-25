<?php

class ScriptDirDetailView extends View {

	public function __construct($route, Detailable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$detail = $this->model->getDetail();
		if($detail) {
			$this->template->addVariables($detail);
			$data = $this->model->getDirectoryScripts();
			$this->template->set('dirs', $this->model->getDirs());
			$this->template->set('scripts', $data);
			if(!count($data)) {
				$this->template->set('noresults', 1);
			}
		} else {
			$this->template->setTemplate('error.html');
			$this->template->set('error', 'Sada nebyla nalezena.');
		}
		return $this->template->output();
	}
}

?>