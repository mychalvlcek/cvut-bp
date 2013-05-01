<?php

class ScriptController extends Controller { 

	public function __construct(ViewModel $model) {
		parent::__construct($model);
	}

	public function lst() {
	}

	public function show($id = 0) {
		$this->model->setId($id);
	}

	public function edit($id = 0) {
		$this->model->setId($id);
		if(count($_POST))
			$this->model->edit($_POST);
	}

}

?>