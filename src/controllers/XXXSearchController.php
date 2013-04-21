<?php

class SearchController {

	public function __construct(Searchable $model) {
		parent::__construct($model);
	}

	public function search($criteria) {
		$this->model->setCritera($criteria);
	}
}

?>