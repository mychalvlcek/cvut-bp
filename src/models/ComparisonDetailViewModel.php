<?php

class ComparisonDetailViewModel extends ViewModel implements Detailable {
	private $id;
	
	public function __construct(ComparisonModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}
	
	public function delete($id) {
		if($this->isAdmin()) {
			if($this->model->delete($id)) {
				$this->addInfo('info', 'Log byl smazán');
			} else {
				$this->addInfo('error', 'Log se nepodařilo smazat');
			}
		} else {
			$this->addInfo('error', 'Nemáte oprávnění');
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

	public function getContainedElements() {
		$sql = $this->model->getSQLElements($this->id, 1);
		$html = $this->model->getHTMLElements($this->id, 1);
		return array_merge($html, $sql);
	}

	public function getNonContainedElements() {
		$sql = $this->model->getSQLElements($this->id, 0);
		$html = $this->model->getHTMLElements($this->id, 0);
		return array_merge($html, $sql);
	}

	public function getOccurrencedScripts() {
		return $this->model->getScripts($this->id, 1);
	}

	public function getNonOccurrencedScripts() {
		return $this->model->getScripts($this->id, 0);
	}

}

?>