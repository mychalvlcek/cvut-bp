<?php

class UserListViewModel extends ViewModel implements Listable, Searchable {
	private $searchName;
	
	public function __construct(UserModel $model) {
		$this->model = $model;
		$this->searchName = '';
	}

	public function getEntityName() {
		return 'Uživatelé';
	}
	
	public function setCriteria($criteria) {
		$this->searchName = $criteria;
	}

	public function getCriteria() {
		return $this->searchName;
	}

	public function getData() {
		if($this->searchName == '')
			return $this->model->getAll();
		return $this->model->findByName($this->searchName);
	
	}
}

?>