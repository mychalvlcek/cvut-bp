<?php

class ScriptDetailViewModel extends ViewModel implements Detailable, Editable {
	private $id;
	
	public function __construct(ScriptModel $model) {
		$this->model = $model;
	}
	
	public function edit($data) {
		//return $this->model->update($data);
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getDetail() {
		return $this->model->findById($this->id);
	}
}

?>