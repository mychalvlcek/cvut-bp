<?php

class RepositoryListViewModel extends RepositoryViewModel implements Listable, Searchable {
	private $criterium;
	
	public function __construct(RepositoryModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
		$this->criterium = '';
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

	public function getEntityName() {
		return 'Repozitáře';
	}
	
	public function setCriteria($criterium) {
		$this->criterium = $criterium;
	}

	public function getCriteria() {
		return $this->criterium;
	}

}

?>