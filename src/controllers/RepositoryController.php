<?php

class RepositoryController extends Controller {

	public function __construct(ViewModel $model) {
		parent::__construct($model);
	}

	public function lst() {
		if(isset($_GET['sort']) && isset($_GET['order'])) {
			$this->model->setSort($_GET['sort'], $_GET['order']);
		}
		if(isset($_POST['delete'])) {
			// private function delete;
			//$this->model->delete($_POST['delete']);
		}
		if(isset($_GET['criterium'])) {
			$this->search($_GET['criterium']);
		}
	}

	public function add() {
		if(count($_POST))
			$this->model->save($_POST);
	}

	public function search($criterium = '') {
		$this->model->setCriteria($criterium);
	}

	public function delete($id) {
		$this->model->delete($id);
	}
	// del
	public function show($id = 0) {
		$this->model->setId($id);
	}
}

?>