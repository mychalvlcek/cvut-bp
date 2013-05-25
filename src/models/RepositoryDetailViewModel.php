<?php

class RepositoryDetailViewModel extends ViewModel implements Detailable, Editable {
	private $id;
	
	public function __construct(RepositoryModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}

	public function edit($data = array(), $files = array()) {
		if(isset($data['name']) && strlen($data['name']) < 1 ) {
			$this->addInfo('error', 'Zadejte název');
		}
		if(count($this->getInfo(0)) == 0) {
			/* REPO SAVE */
			$data['author'] = $this->getUser()->id;
			$id = $this->model->update($this->id, $data);
			if($id) {
				$this->addInfo('info', 'Repozitář byl upraven');
			} else {
				$this->addInfo('error', 'Repozitář se nepodařilo upravit');
			}
			/* FILE HANDLING */
			if($this->checkFiles($files['file'])) {
				// sql parse
				$sqlParser = new SQLRepositoryParser();
				foreach($files['file']['tmp_name'] as $file) {
					$sqlParser->addContent(file_get_contents($file));
				}
				$sqlParser->parse();
				foreach ($sqlParser->getTables() as $table) {
					$this->model->insertSqlArtefacts(array(':repository_id' => $this->id, ':type' => 'table', 'name' => $table));
				}
				foreach ($sqlParser->getColumns() as $column) {
					$this->model->insertSqlArtefacts(array(':repository_id' => $this->id, ':type' => 'column', 'name' => $column));
				}
			}
			/* URL HANDLING */
			if(isset($data['urls']) && $data['urls'] != '') {
				$urls = explode("\r\n", $data['urls']);
				$htmlParser = new HTMLRepositoryParser();
				foreach($urls as $url) {
					if($url != '') {
						$htmlParser->addUrl(trim($url));
					}
				}
				$htmlParser->parse();
				foreach ($htmlParser->getAnchors() as $anchor) {
					$this->model->insertHTMLElements(array(':repository_id' => $this->id, ':type' => 'anchor', ':label' => $anchor['anchor_title'], ':value' => $anchor['anchor_href']));
				}
				foreach ($htmlParser->getInputs() as $input) {
					$this->model->insertHTMLElements(array(':repository_id' => $this->id, ':type' => 'input', ':label' => $input['input_label'], ':value' => $input['input_name']));
				}
			}
			if($id) {
				$this->addInfo('info', 'SQL bylo zpracováno');
				header('Location: /repository/show/'.$this->id);
				die();
			} else {
				$this->addInfo('error', 'SQL se nepodařilo zpracovat');
			}
		}
	}

	private function checkFiles($files) {
		if($files['size'][0]) return true;
		return false;
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

	public function deleteElement($id) {
		$rep_id = $this->model->getRepositoryByElement($id);
		if($this->model->deleteElement($id)) {
			$this->addInfo('info', 'Element byl smazán');
		} else {
			$this->addInfo('error', 'Element se nepodařilo smazat');
		}
		header('Location: /repository/show/'.$rep_id);
		die();
	}

	public function clear($id) {
		if($this->model->clear($id)) {
			$this->addInfo('info', 'Repozitář byl vyprázdněn');
		} else {
			$this->addInfo('error', 'Repozitář se nepodařilo vyprázdnit');
		}
		header('Location: /repository/show/'.$id);
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