<?php

class RepositoryViewModel extends ViewModel {
	
	public function __construct(RepositoryModel $model, SessionManager $sessionManager) {
		parent::__construct($model, $sessionManager);
	}

	public function save($data = array(), $files = array()) {
		if(isset($data['name']) && strlen($data['name']) < 1 ) {
			$this->addInfo('error', 'Zadejte název');
		}
		if(count($this->getInfo(0)) == 0) {
			/* REPO SAVE */
			$data['author'] = $this->getUser()->id;
			$id = $this->model->insert($data);
			if($id) {
				$this->addInfo('info', 'Repozitář #<strong>'.$id.'</strong> byl vytvořen');
			} else {
				$this->addInfo('error', 'Repozitář se nepodařilo vytvořit');
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
					$this->model->insertSqlArtefacts(array(':repository_id' => $id, ':type' => 'table', 'name' => $table));
				}
				foreach ($sqlParser->getColumns() as $column) {
					$this->model->insertSqlArtefacts(array(':repository_id' => $id, ':type' => 'column', 'name' => $column));
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
					$this->model->insertHTMLElements(array(':repository_id' => $id, ':type' => 'anchor', ':label' => strip_tags($anchor['anchor_title']), ':value' => $anchor['anchor_href']));
				}
				foreach ($htmlParser->getInputs() as $input) {
					$this->model->insertHTMLElements(array(':repository_id' => $id, ':type' => 'input', ':label' => $input['input_label'], ':value' => $input['input_name']));
				}
			}
		}
	}

	private function checkFiles($files) {
		if($files['size'][0]) return true;
		return false;
	}
}

?>