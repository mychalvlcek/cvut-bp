<?php

class FrontController {
	private $router;
	private $controller;
	private $view;

	public function __construct(Router $router) {
		$this->router = $router;
	}

	public function route($url = '') {
		$routeParts = explode('/', $url);

		$routeName = $this->router->getRouteName($routeParts);
		$route = $this->router->getRoute($routeName);

		$action = isset($routeParts[1])?$routeParts[1]:'';
		$action = ($action == 'list'?'lst':$action);

		$param = isset($routeParts[2])?$routeParts[2]:'';

		$modelName = $route->model;
		$viewModelName = $route->viewModel;
		$controllerName = $route->controller;
		$viewName = $route->view;

		$options = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_PERSISTENT => true
					);

		$model = new $modelName(new PDO(DB_DRIVER.':host='.DB_HOST.';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options));
		$viewModel = new $viewModelName($model, new SessionManager());
		$this->controller = new $controllerName($viewModel);
		$this->view = new $viewName($routeName, $viewModel, new Template($routeName));
		if ($action != '') {
			if (method_exists($this->controller, $action) && is_callable(array($this->controller, $action))) {
				$this->controller->{$action}($param);
			} else {
				trigger_error('Neexistujici akce');
			}
		}
	}
	
	public function output() {
		return $this->view->display();
	}
} 

?>