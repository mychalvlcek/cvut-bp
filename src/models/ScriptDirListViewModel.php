<?php

class ScriptDirListViewModel extends ViewModel implements Listable {
	
	public function __construct(ScriptDirModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}

	public function getEntityName() {
		return 'Sady testovacích skriptů';
	}

	public function save($name) {
		if(strlen($name) < 1 ) {
			$this->addInfo('error', 'Zadejte název');
		}
		if(count($this->getInfo()) == 0) {
			$id = $this->model->insert($name, $this->getUser()->id);
			if($id) {
				$this->addInfo('info', 'Sada <strong>'.$name.'</strong> byla vytvořena');
			} else {
				$this->addInfo('error', 'Sadu se nepodařilo vytvořit');
			}
		}
	}

	public function getData() {
		return $this->model->getAll();
	
	}

	public function getRecordsCount() {
		return $this->model->getAllCount();
	}
}

?>