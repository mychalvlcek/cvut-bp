<?php
//class PagedListViewModel implements Pageable, Listable { - zde neni zadna konkretni reference napr searchName
class PagedUserListViewModel implements Pageable, Listable {
	private $model;
	private $page = 1;

	public function __construct(UserModel $model) {
		$this->model = $model;
	}

	public function getData() {
		return $this->model->getAll();
	}
	

	public function find($limit, $offset) {
		return $this->model->findByName($this->searchName, $limit, $offset);
	}

	public function getRecordsPerPage() {
		return 20;
	}

	public function getCurrentPage() {
		return $this->page;
	}

	public function getTotalResults() {
		//Simple example, in reality the model would have a count method for performance reasons
		return count($this->model->findByName($this->searchName));
	}

	public function setPage($page) {
		$this->page = $page;
	}
}

?>