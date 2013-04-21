<?php

class LogListViewModel extends ViewModel implements Listable {
	
	public function __construct(LogModel $model) {
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