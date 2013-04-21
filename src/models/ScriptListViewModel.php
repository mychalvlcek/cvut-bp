<?php

class ScriptListViewModel extends ViewModel implements Listable, Searchable {
	private $criterium;
	
	public function __construct(ScriptModel $model) {
		$this->model = $model;
		$this->criterium = '';
	}

	public function getEntityName() {
		return 'Testovací skripty';
	}

	public function setCriteria($criteria) {
		$this->criterium = $criteria;
	}

	public function getCriteria() {
		return $this->criterium;
	}

	public function getData() {
		return $this->model->getAll();
	
	}
}

?>