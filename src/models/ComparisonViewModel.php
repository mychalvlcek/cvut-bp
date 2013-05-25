<?php

class ComparisonViewModel extends ViewModel {
	
	public function __construct(ComparisonModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
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
		$this->checkValues($data);
		if(count($this->getInfo(0)) == 0) {
			$data['author'] = $this->getUser()->id;
			$id = $this->model->insert($data);
			if($id) {
				// srovnani
				$scripts = $this->model->getAllScriptsByDir($data['script_dir']);
				$elements = $this->model->getElementsByRepository($data['repository']);

				$comparator = new ScriptComparator();
				$comparator->setRule($data['rule']);
				$comparator->setScripts($scripts);
				$comparator->setRepository($elements);
				$comparator->compare();

				$elements = $comparator->getContainedElements();
				$badElements = $comparator->getNotContainedElements();
				$rightScripts = $comparator->getRightScripts();
				$badScripts = $comparator->getBadScripts();

				foreach($elements as $element) {
					$this->model->insertElement(array($id, $element['id'], $element['type'], 1));
				}
				foreach($badElements as $element) {
					$this->model->insertElement(array($id, $element['id'], $element['type'], 0));
				}
				foreach($rightScripts as $script) {
					$this->model->insertScript(array($id, $script, 1));
				}
				foreach($badScripts as $script) {
					$this->model->insertScript(array($id, $script, 0));
				}

				$this->addInfo('info', 'Proces srovnání úspěšně proběhl');
			} else {
				$this->addInfo('error', 'Proces srovnání neproběhl');
			}
		}
	}

	private function checkValues($data) {
		if(isset($data['name']) && strlen($data['name']) < 1 ) {
			$this->addInfo('error', 'Zadejte název');
		}
		if(isset($data['script_dir']) && strlen($data['script_dir']) < 1 ) {
			$this->addInfo('error', 'Vyberte sadu');
		}
		if(isset($data['repository']) && strlen($data['repository']) < 1 ) {
			$this->addInfo('error', 'Vyberte repozitář');
		}
		if(isset($data['rule']) && strlen($data['rule']) < 1 ) {
			$this->addInfo('error', 'Vyberte pravidla');
		}
	}
}

?>