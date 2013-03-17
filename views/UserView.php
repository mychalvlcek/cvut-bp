<?php

class UserView extends View {

	public function __construct($route, Model $model, Template $template) {
		parent::__construct($route, $model, $template);
	}
	
	public function output() {
		$users = $this->model->getAll();
		$this->template->set('users', $users);
		$this->template->setTemplate('list.html');
		return $this->template->output();
	}
}

?>