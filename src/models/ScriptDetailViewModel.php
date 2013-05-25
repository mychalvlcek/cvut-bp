<?php

class ScriptDetailViewModel extends ViewModel implements Detailable, Editable {
	private $id;
	
	public function __construct(ScriptModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}
	
	public function edit($data) {
		if($this->model->update($this->id, $data)) {
			$this->addInfo('info', 'Skript byl upraven');
			header('Location: /script/show/'.$this->id);
			die();
		} else {
			$this->addInfo('error', 'Skript se nepodařilo upravit');
		}
	}

	public function setId($id) {
		$this->id = $id;
	}


	public function delete($id) {
		if($this->isAdmin() && $this->model->delete($id)) {
			$this->addInfo('info', 'Skript byl smazán');
		} else {
			$this->addInfo('error', 'Skript se nepodařilo smazat');
		}
		header('Location: /dir/list/');
		die();
	}

	public function getDetail() {
		return $this->model->findById($this->id);
	}

	public function getScriptSteps() {
		return $this->model->findScriptSteps($this->id);
	}

	public function getScriptDirs() {
		return $this->model->getScriptDirs($this->id);
	}
}

?>