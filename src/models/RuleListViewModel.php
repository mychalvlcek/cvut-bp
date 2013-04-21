<?php

class RuleListViewModel extends ViewModel implements Listable {
	
	public function __construct(RuleModel $model) {
		$this->model = $model;
	}

	public function getEntityName() {
		return 'Pravidla';
	}

	public function getData() {
		return $this->model->getAll();
	}
}

?>