<?php

/**
 * Router class stores static routes
 */
class Router {
	private $routes = array();
	
	public function __construct() {
		// srovnavani
		$this->routes['comparison'] = new Route('ComparisonModel', 'ComparisonViewModel', 'ComparisonView', 'ComparisonController');
		$this->routes['log_list'] = new Route('ComparisonModel', 'ComparisonListViewModel', 'PagedListView', 'ComparisonController');
		$this->routes['log_show'] = new Route('ComparisonModel', 'ComparisonDetailViewModel', 'ComparisonDetailView', 'ComparisonController');
		$this->routes['log_delete'] = new Route('ComparisonModel', 'ComparisonDetailViewModel', 'DetailView', 'ComparisonController');
		// repozitare
		$this->routes['repository_list'] = new Route('RepositoryModel', 'RepositoryListViewModel', 'PagedSearchableListView', 'RepositoryController');
		$this->routes['repository_show'] = new Route('RepositoryModel', 'RepositoryDetailViewModel', 'RepositoryDetailView', 'RepositoryController');
		$this->routes['repository_delete'] = new Route('RepositoryModel', 'RepositoryDetailViewModel', 'DetailView', 'RepositoryController');
		$this->routes['repository_deleteelement'] = new Route('RepositoryModel', 'RepositoryDetailViewModel', 'DetailView', 'RepositoryController');
		$this->routes['repository_clear'] = new Route('RepositoryModel', 'RepositoryDetailViewModel', 'DetailView', 'RepositoryController');
		$this->routes['repository_edit'] = new Route('RepositoryModel', 'RepositoryDetailViewModel', 'RepositoryDetailView', 'RepositoryController');
		$this->routes['repository_add'] = new Route('RepositoryModel', 'RepositoryViewModel', 'View', 'RepositoryController');
		// sady skriptu
		$this->routes['dir_list'] = new Route('ScriptDirModel', 'ScriptDirListViewModel', 'PagedListView', 'ScriptDirController');
		$this->routes['dir_show'] = new Route('ScriptDirModel', 'ScriptDirDetailViewModel', 'ScriptDirDetailView', 'ScriptDirController');
		$this->routes['dir_delete'] = new Route('ScriptDirModel', 'ScriptDirDetailViewModel', 'ScriptDirDetailView', 'ScriptDirController');
		$this->routes['dir_edit'] = new Route('ScriptDirModel', 'ScriptDirDetailViewModel', 'ScriptDirEditView', 'ScriptDirController');
		// skripty
		$this->routes['script_show'] = new Route('ScriptModel', 'ScriptDetailViewModel', 'ScriptDetailView', 'ScriptController');
		$this->routes['script_edit'] = new Route('ScriptModel', 'ScriptDetailViewModel', 'ScriptEditView', 'ScriptController');
		$this->routes['script_delete'] = new Route('ScriptModel', 'ScriptDetailViewModel', 'ScriptEditView', 'ScriptController');
		// uzivatele - admin
		$this->routes['user_list'] = new Route('UserModel', 'UserListViewModel', 'PagedSearchableListView', 'UserController');
		$this->routes['user_show'] = new Route('UserModel', 'UserDetailViewModel', 'DetailView', 'UserController');
		$this->routes['user_delete'] = new Route('UserModel', 'UserDetailViewModel', 'DetailView', 'UserController');
		$this->routes['user_makeadmin'] = new Route('UserModel', 'UserDetailViewModel', 'DetailView', 'UserController');
		$this->routes['user_makeuser'] = new Route('UserModel', 'UserDetailViewModel', 'DetailView', 'UserController');
		// prihlasovaci system
		$this->routes['auth_login'] = new Route('AuthModel', 'AuthViewModel', 'AuthView', 'AuthController');
		$this->routes['auth_logout'] = new Route('AuthModel', 'AuthViewModel', 'AuthView', 'AuthController');
		$this->routes['auth_register'] = new Route('AuthModel', 'AuthViewModel', 'AuthView', 'AuthController');
		$this->routes['auth_password'] = new Route('AuthModel', 'AuthViewModel', 'ChangePasswordView', 'AuthController');
		// chyby
		$this->routes['error'] = new Route('Model', 'ErrorViewModel', 'ErrorView', 'ErrorController');
	}
	public function getRoute($routeName) {
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
	
}

?>