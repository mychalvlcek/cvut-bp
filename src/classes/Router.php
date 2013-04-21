<?php

/**
 * Router class stores static routes
 */
class Router {
	private $routes = array();
	
	public function __construct() {
		$this->routes['comparison'] = new Route('ComparisonModel', 'ComparisonViewModel', 'ComparisonView', 'ComparisonController');
		
		$this->routes['repository_list'] = new Route('RepositoryModel', 'RepositoryListViewModel', 'RepositoryListView', 'RepositoryController');
		$this->routes['repository_show'] = new Route('RepositoryModel', 'RepositoryDetailViewModel', 'DetailView', 'RepositoryController');
		$this->routes['repository_add'] = new Route('RepositoryModel', 'RepositoryViewModel', 'RepositoryView', 'RepositoryController');

		$this->routes['script_list'] = new Route('ScriptModel', 'ScriptListViewModel', 'ListView', 'ScriptListController');
		$this->routes['script_show'] = new Route('ScriptModel', 'ScriptDetailViewModel', 'DetailView', 'ScriptDetailController');

		$this->routes['rule_list'] = new Route('RuleModel', 'RuleListViewModel', 'ListView', 'RuleController');

		$this->routes['user_list'] = new Route('UserModel', 'UserListViewModel', 'ListView', 'UserListController');
		$this->routes['user_show'] = new Route('UserModel', 'UserDetailViewModel', 'DetailView', 'UserDetailController');

		$this->routes['log_list'] = new Route('LogModel', 'LogListViewModel', 'ListView', 'LogListController');

		$this->routes['auth_login'] = new Route('AuthModel', 'AuthViewModel', 'AuthView', 'AuthController');
		$this->routes['auth_logout'] = new Route('AuthModel', 'AuthViewModel', 'AuthView', 'AuthController');
		$this->routes['auth_register'] = new Route('AuthModel', 'AuthViewModel', 'AuthView', 'AuthController');
		
		$this->routes['error'] = new Route('Model', 'ViewModel', 'ErrorView', 'ErrorController');
	}
	
	public function getRoute($route) {
		$route = strtolower($route);
		if(array_key_exists($route, $this->routes))
			return $this->routes[$route];
		return $this->routes['error'];
	}

	public function getRouteNew($routeName) {
		if(array_key_exists($routeName, $this->routes))
			return $this->routes[$routeName];
		return $this->routes['error'];
	}

	public function getRouteName($route) {
		if(sizeof($route) == 1 && $route[0] == '') {
			return 'comparison'; // default route
		} elseif(sizeof($route) == 1) {
			return $route[0];
		} else {
			return $route[0].'_'.$route[1];
		}
	}

	/*
	public function find($route) { 
		$routeParts = explode('/', $route);

		//A name based on the first two parts such as "UserEdit" or "UserList"
		$name = $routeParts[0] . $routeparts[1];

		$viewName = $name . 'View';
		//Does the class e.g. "UserListView" exist?
		if (class_exists($viewName)) {
			$view = new $viewName;
		} else {
			//Something must be displayed, perhaps an error message?
			$view = new DefaultView;
		}

		//E.g. "UserEditController"
		$controllerName = $name . 'Controller';
		if (class_exists($controllerName)) {
			$controller = new $controllerName;
		} else {
			$controller = null;
		}

		//Finally, return the matched route 
		return new Route($view, $controller);
	}
	*/
}

?>