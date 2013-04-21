<?php
class View {
	protected $model;
	protected $route;
	protected $template;

	public function __construct($route, ViewModel $model, Template $template) {
		$this->model = $model;
		$this->route = $route;
		$this->template = $template;
	}

	public function init() {
		$this->template->set('menu', $this->model->getMenu());
		$this->template->set('route', $this->route);
		$this->template->setInfo($this->model->getInfo());
		$this->template->set('auth_username', $this->model->userName());
	}

	public function output() {
		return $this->template->output();
	}

}

?>