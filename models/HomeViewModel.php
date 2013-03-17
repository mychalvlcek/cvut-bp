<?php

class HomeViewModel extends Model {
	private $model;
	
	public function __construct(HomeModel $model) {
		$this->model = $model;
	}

	public function processImport($url) {
		$this->model->processUrl($url);
	}

	public function getFile() {
		return $this->model->getFile();
	}

	public function getAnchors() {
		return $this->model->getAnchors();
	}
}

?>