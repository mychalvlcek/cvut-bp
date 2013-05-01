<?php

class ComparisonViewModel extends ViewModel {
	
	public function __construct(ComparisonModel $model) {
		$this->model = $model;
	}

	public function getScriptSets() {
		return $this->model->getScriptSets();
	}

	public function getRepositories() {
		return $this->model->getRepositories();
	}

	public function getRules() {
		return $this->model->getRules();
	}

	public function save($data = array()) {
		$data['author'] = $this->getUser()->id;
		if($this->model->insert($data)) {
			$this->addInfo('info', 'Proces srovnání úspěšně proběhl');
		} else {
			$this->addInfo('error', 'Proces srovnání neproběhl');
		}
	}
}

?>