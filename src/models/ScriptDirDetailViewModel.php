<?php

class ScriptDirDetailViewModel extends ViewModel implements Detailable {
	private $id;
	
	public function __construct(ScriptDirModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}

	public function edit($name) {
		if($this->model->update($this->id, $name)) {
			$this->addInfo('info', 'Sada byla přejmenována');
			header('Location: /dir/show/'.$this->id);
			die();
		} else {
			$this->addInfo('error', 'Sadu se nepodařilo přejmenovat');
		}
	}

	public function delete($id) {
		if($id != 1) {
			if($this->model->delete($id)) {
				$this->addInfo('info', 'Sada byla smazána');
			} else {
				$this->addInfo('error', 'Sadu se nepodařilo smazat');
			}
		} else {
			$this->addInfo('error', 'Nelze smazat defaultní složku');
		}
		header('Location: /dir/list/');
		die();
	}

	public function move($scripts, $dir) {
		if($this->model->move($scripts, $dir)) {
			$this->addInfo('info', 'Skripty byly přesunuty');
			header('Location: /dir/show/'.$dir);
			die();
		} else {
			$this->addInfo('error', 'Skripty se nepodařilo přesunout');
		}
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getDetail() {
		return $this->model->findById($this->id);
	}

	public function getDirs() {
		return $this->model->getAll();
	}

	public function getDirectoryScripts() {
		return $this->model->findDirectoryScripts($this->id);
	}
}

?>