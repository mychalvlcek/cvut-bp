<?php

class ComparisonView extends View {

	public function __construct($route, ViewModel $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$this->template->set('scripts', $this->model->getScriptSets());
		$this->template->set('repositories', $this->model->getRepositories());
		$this->template->set('rules', $this->model->getRules());
		$this->template->addVariables($this->model->getPostData());
		return $this->template->output();
	}
}

?>