<?php

class FrontController {
	private $controller;
	private $view;
	//private $route;

	public function __construct(Router $router, $controller, $action = null) {
		$route = $router->getRoute($controller);

		$modelName = $route->model;
		$viewModelName = $route->viewModel;
		$controllerName = $route->controller;
		$viewName = $route->view;

		$model = new $modelName(Database::getInstance());
		$viewModel = new $viewModelName($model);
		$this->controller = new $controllerName($viewModel);
		$this->view = new $viewName($controller, $viewModel, new Template($controller));
		if (!empty($action)) {
			if (method_exists($this->controller, $action) && is_callable(array($this->controller, $action))) {
				$this->controller->{$action}();
			} else {
				trigger_error('Neexistujici akce');
			}
		}
	}

	/*
	public function __construct(Router $router, $route, $action = null) {
		$this->route = $route;
		$name = ucfirst($route);
		$modelName = $name.'Model';
		$controllerName = $name.'Controller';
		$viewName = $name.'View';
		$viewModelName = $name.'ViewModel';
		$model = new $modelName(Database::getInstance());
		$this->controller = new $controllerName($model);
		$this->view = new $viewName($name, $model, new Template());

		if (!empty($action)) $this->controller->{$action}();

		// stranka nenalezena
		// akce neni k dispozici
	}
	*/

	public function route() {

	}
	
	public function output() {
		return $this->view->output();
	}
} 

?>