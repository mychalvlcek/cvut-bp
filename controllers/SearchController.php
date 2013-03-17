<?php

class SearchController {
	private $model;

	public function __construct(Searchable $model) {
		$this->model = $model;
	}

	public function search($criteria) {
		$this->model->setCritera($criteria);
	}
}

?>