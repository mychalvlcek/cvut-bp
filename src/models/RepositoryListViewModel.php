<?php

class RepositoryListViewModel extends RepositoryViewModel implements Listable, Searchable {
	private $searchTitle;
	
	public function __construct(RepositoryModel $model) {
		$this->searchTitle = '';
		$this->model = $model;
	}

	public function getEntityName() {
		return 'Repozitáře';
	}
	
	public function setCriteria($criteria) {
		$this->searchTitle = $criteria;
	}

	public function getCriteria() {
		return $this->searchTitle;
	}

	public function getData() {
		if($this->model->isLoggedUserAdmin()) {
			if($this->searchTitle == '')
				return $this->model->getAll('repository');
			return $this->model->findByName($this->searchTitle);
		} else {
			if($this->searchTitle == '')
				return $this->model->getAllByAuthor($this->model->getLoggedUserId());
			return $this->model->findByName($this->searchTitle);
		}
	}

	public function delete($id = 0) {
		if($this->model->delete($id)) {
			$this->addInfo('info', 'Repozitář byl odstraněn');
		} else {
			$this->addInfo('error', 'Repozitář se nepodařilo odstranit');
		}
	}
}

?>