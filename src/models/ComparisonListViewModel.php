<?php

class ComparisonListViewModel extends ViewModel implements Listable {
	
	public function __construct(ComparisonModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}

	public function getEntityName() {
		return 'Logy';
	}

	public function getData() {
		return $this->model->getAll();
	}

	public function getRecordsCount() {
		return $this->model->getAllCount();
	}
}

?>