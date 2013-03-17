<?php

class Router { 
    private $table = array(); 
     
    public function __construct() { 
        $this->table['home'] = new Route('HomeModel', 'HomeViewModel', 'HomeView', 'HomeController');
        $this->table['user'] = new Route('UserModel', 'UserListViewModel', 'ListView', 'UserController');
        $this->table['error'] = new Route('Model', 'Model', 'ErrorView', 'Controller');
    } 
     
    public function getRoute($route) { 
        $route = strtolower($route);
        if(array_key_exists($route, $this->table))
        	return $this->table[$route];
        return $this->table['error'];
    } 
} 

?>