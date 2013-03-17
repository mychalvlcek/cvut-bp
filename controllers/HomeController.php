<?php

class HomeController {
	private $model;

	public function __construct(HomeViewModel $model) {
		$this->model = $model;
	}

	public function url() {
		$this->model->processImport(isset($_POST['url'])?$_POST['url']:'');
	}
}

?>