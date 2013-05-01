<?php

class ComparisonDetailViewModel extends ViewModel implements Detailable, Editable {
	private $id;
	
	public function __construct(ComparisonModel $model) {
		$this->model = $model;
	}
	
	public function edit($data) {
		//return $this->model->update($data);
	}

	public function delete($id) {
		if($this->model->delete($id)) {
			$this->addInfo('info', 'Log byl smazán');
		} else {
			$this->addInfo('error', 'Log se nepodařilo smazat');
		}
		header('Location: /log/list/');
		die();
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getDetail() {
		return $this->model->findById($this->id);
	}

}

?>