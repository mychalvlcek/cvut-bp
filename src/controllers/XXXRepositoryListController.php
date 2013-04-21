<?php

class RepositoryListController extends Controller {

	public function __construct(RepositoryListViewModel $model) {
		parent::__construct($model);
	}

	public function save() {
		$this->model->processImport(isset($_POST['url'])?$_POST['url']:'');
		//$this->model->save($_POST);
	}
}

?>