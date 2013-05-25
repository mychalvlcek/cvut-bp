<?php

class UserListViewModel extends ViewModel implements Listable, Searchable {
	private $criterium;
	
	public function __construct(UserModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
		$this->criterium = '';
	}

	public function getEntityName() {
		return 'Uživatelé';
	}
	
	public function setCriteria($criteria) {
		$this->criterium = $criteria;
	}

	public function getCriteria() {
		return $this->criterium;
	}

	public function getData() {
		if($this->criterium == '')
			return $this->model->getAll();
		return $this->model->findByName($this->criterium);
	}

	public function getRecordsCount() {
		if($this->criterium == '')
			return $this->model->getAllCount();
		return $this->model->findByNameCount($this->criterium);
	}
}

?>