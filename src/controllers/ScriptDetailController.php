<?php

class ScriptDetailController extends Controller {

	public function __construct(ScriptDetailViewModel $model) {
		parent::__construct($model);
	}
	public function show($id = 0) {
		$this->model->setId($id);
	}
}

?>