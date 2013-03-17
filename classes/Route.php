<?php

class Route {
	public $model;
	public $view;
	public $viewModel;
	public $controller;
	
	public function __construct($model, $viewModel, $view, $controller) {
		$this->model = $model;
		$this->viewModel = $viewModel;
		$this->view = $view;
		$this->controller = $controller;
	}
} 

?>