<?php

class RepositoryListController extends Controller {

	public function __construct(ViewModel $model) {
		parent::__construct($model);
	}

	public function lst() {
		if(isset($_POST['delete'])) {
			// private function delete;
			//$this->model->delete($_POST['delete']);
		}
		if(isset($_GET['criterium'])) {
			$this->search($_GET['criterium']);
		}
	}

	public function search($criterium = '') {
		$this->model->setCriteria($criterium);
	}

	public function delete($id) {
		$this->model->delete($id);
	}

?>