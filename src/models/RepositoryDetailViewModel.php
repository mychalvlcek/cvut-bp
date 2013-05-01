<?php

class RepositoryDetailViewModel extends ViewModel implements Detailable, Editable {
	private $id;
	
	public function __construct(RepositoryModel $model) {
		$this->model = $model;
	}
	
	public function edit($data) {
		//return $this->model->update($data);
	}

	public function delete($id) {
		if($this->model->delete($id)) {
			$this->addInfo('info', 'Repozitář byl smazán');
		} else {
			$this->addInfo('error', 'Repozitář se nepodařilo smazat');
		}
		header('Location: /repository/list/');
		die();
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getDetail() {
		return $this->model->findById($this->id);
	}

	public function getSQLElements() {
		return $this->model->findRepositoryElements($this->id, 'sql');
	}

	public function getHTMLElements() {
		return $this->model->findRepositoryElements($this->id, 'html');
	}
}

?>