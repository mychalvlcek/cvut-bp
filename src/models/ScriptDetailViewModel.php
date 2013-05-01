<?php

class ScriptDetailViewModel extends ViewModel implements Detailable, Editable {
	private $id;
	
	public function __construct(ScriptModel $model) {
		$this->model = $model;
	}
	
	public function edit($data) {
		if($this->model->update($data)) {
			$this->addInfo('info', 'Skript byl upraven');
		} else {
			$this->addInfo('error', 'Skript se nepodařilo upravit');
		}
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getDetail() {
		return $this->model->findById($this->id);
	}
}

?>