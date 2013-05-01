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

	public function getData($limit = '') {
		if($this->model->isAdmin()) {
			// admin
			if($this->searchTitle == '')
				return $this->model->getAll('repository', $limit);
			return $this->model->findByName($this->searchTitle);
		} else {
			// classic user
			if($this->searchTitle == '')
				return $this->model->getAllByAuthor($this->model->getLoggedUserId());
			return $this->model->findByName($this->searchTitle);
		}
	}

	public function getRecordsCount($limit = '') {
		return $this->model->getRecordsCount('repository');
		if($this->model->isAdmin()) {
			// admin
			if($this->searchTitle == '')
				return $this->model->getRecordsCount('repository');
			return $this->model->findByName($this->searchTitle);
		} else {
			// classic user
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