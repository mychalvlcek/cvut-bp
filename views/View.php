<?php

class View {
	protected $model;
	protected $route;
	protected $template;

	public function __construct($route, Model $model, Template $template) {
		$this->model = $model;
		$this->route = $route;
		$this->template = $template;
	}
	 
	public function output($data = '') {
		$this->template->set('route', $this->route. ' - View.php');
		return $this->template->output();
	}
}

?>