<?php

class ScriptDirController extends Controller { 

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
		// add
		if(isset($_POST['name'])) {
			$this->add($_POST['name']);
		}
	}
	// SMAZANI
	public function delete($id) {
			$this->model->delete($id);
	}
	// DETAIL
	public function show($id = 0) {
		$this->model->setId($id);
		// move
		if(isset($_POST['directory']) && isset($_POST['scripts'])) {
			$this->move($_POST['scripts'], $_POST['directory']);
		}
	}
	// INSERT
	public function add($name = '') {
		$this->model->save($name);
	}
	// EDIT
	public function edit($id = 0) {
		$this->model->setId($id);
		if(count($_POST))
			$this->model->edit($_POST['name']);
	}
	// move
	public function move($scripts = array(), $dir = 0) {
		$this->model->move($scripts, $dir);
	}

}

?>