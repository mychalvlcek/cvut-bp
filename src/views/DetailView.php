<?php

class DetailView extends View {

	public function __construct($route, Detailable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		//$this->template->setTemplate('user_edit.html'); //
		$user = $this->model->getDetail();
		if($user) {
			$this->template->addVariables($user);
		} else {
			$this->template->setTemplate('error_usernotfound.html');
		}
		return $this->template->output();
	}
}

?>