<?php

class RepositoryViewModel extends ViewModel {
	
	public function __construct(RepositoryModel $model) {
		$this->model = $model;
	}

	public function processImport($url) {
		$this->model->processUrl($url);
	}

	public function save($data = array()) {
		$data['author'] = $this->getLoggedUserId();
		if($this->model->insert($data)) {
			$this->addInfo('info', 'Repozitář byl vytvořen');
		} else {
			$this->addInfo('error', 'Repozitář se nepodařilo vytvořit');
		}
	}
}

?>