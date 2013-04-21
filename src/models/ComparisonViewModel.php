<?php

class ComparisonViewModel extends ViewModel {
	
	public function __construct(ComparisonModel $model) {
		$this->model = $model;
	}

	public function getScriptSets() {
		return $this->model->getAll('script');
	}

	public function getRepositories() {
		return $this->model->getAll('repository');
	}

	public function save($data = array()) {
		$data['author'] = $this->getLoggedUserId();
		if($this->model->insert($data)) {
			$this->addInfo('info', 'Proces srovnání úspěšně proběhl');
		} else {
			$this->addInfo('error', 'Proces srovnání neproběhl');
		}
	}
}

?>