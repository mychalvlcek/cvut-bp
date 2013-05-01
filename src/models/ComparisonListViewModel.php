<?php

class ComparisonListViewModel extends ViewModel implements Listable {
	
	public function __construct(ComparisonModel $model) {
		$this->model = $model;
	}

	public function getEntityName() {
		return 'Logy';
	}

	public function getData() {
		return $this->model->getAll();
	}
}

?>