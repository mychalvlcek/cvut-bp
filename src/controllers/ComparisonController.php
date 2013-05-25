<?php

class ComparisonController extends Controller {

	public function __construct(ViewModel $model) {
		parent::__construct($model);

		if(count($_POST))
			$this->model->save($_POST);
	}

	public function lst() {
		if(isset($_GET['page'])) {
			$this->model->setPage($_GET['page']);
		}
	}

	public function show($id = 0) {
		$this->model->setId($id);
	}

	// SMAZANI
	public function delete($id) {
		$this->model->delete($id);
	}

}

?>