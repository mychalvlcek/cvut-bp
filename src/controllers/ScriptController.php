<?php

class ScriptController extends Controller { 

	public function __construct(ViewModel $model) {
		parent::__construct($model);
	}

	public function lst() {
		// razeni
		if(isset($_GET['sort']) && isset($_GET['order'])) {
			$this->model->setSort($_GET['sort'], $_GET['order']);
		}
		// strankovani
		if(isset($_GET['page'])) {
			$this->model->setPage($_GET['page']);
		}
		// mazani - DEL
		if(isset($_POST['delete'])) {
			// private function delete;
			//$this->model->delete($_POST['delete']);
		}
	}
	// SMAZANI
	public function delete($id) {
			$this->model->delete($id);
	}
	// DETAIL
	public function show($id = 0) {
		$this->model->setId($id);
	}
	// EDIT
	public function edit($id = 0) {
		$this->model->setId($id);
		if(count($_POST))
			$this->model->edit($_POST);
	}

}

?>