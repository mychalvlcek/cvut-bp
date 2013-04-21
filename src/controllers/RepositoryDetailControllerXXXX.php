<?php

class RepositoryDetailController extends Controller {

	public function __construct(RepositoryDetailViewModel $model) {
		parent::__construct($model);
	}
	public function show($id = 0) {
		$this->model->setId($id);
	}
}

?>