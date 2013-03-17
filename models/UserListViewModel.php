<?php

class UserListViewModel implements Listable, Searchable {
	private $searchName;
	private $model;
	
	public function __construct(UserModel $model) {
		$this->searchName = '';
		$this->model = $model;
	}
	
	public function setCriteria($criteria) {
		$this->searchName = $criteria;
	}

	public function getData() {
		if($this->searchName == '')
			return $this->model->getAll();
		return $this->model->findByName($this->searchName);
	
	}
}

?>