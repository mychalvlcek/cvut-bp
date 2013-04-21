<?php

/**
 * Route object represents URL route divided to components names.
 */
class Route {
	/**
	 * Title of requested Model class
	 * @access public
	 * @var string
	 */
	public $model;
	/**
	 * Title of requested View class
	 * @access public
	 * @var string
	 */
	public $view;
	/**
	 * Title of requested ViewModel class
	 * @access public
	 * @var string
	 */
	public $viewModel;
	/**
	 * Title of requested Controller class
	 * @access public
	 * @var string
	 */
	public $controller;
	
	public function __construct($model, $viewModel, $view, $controller) {
		$this->model = $model;
		$this->viewModel = $viewModel;
		$this->view = $view;
		$this->controller = $controller;
	}
}

?>