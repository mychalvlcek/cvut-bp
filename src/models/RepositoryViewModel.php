<?php

class RepositoryViewModel extends ViewModel {
	
	public function __construct(RepositoryModel $model) {
		$this->model = $model;
	}

	public function save($data = array(), $files = array()) {
		if(isset($data['name']) && strlen($data['name']) < 1 ) {
			$this->addInfo('error', 'Zadejte název');
		}
		if(count($this->getInfo()) == 0) {
			$data['author'] = $this->getUser()->id;
			$id = $this->model->insert($data);
			if($id) {
				$this->addInfo('info', 'Repozitář #<strong>'.$id.'</strong> byl vytvořen');
			} else {
				$this->addInfo('error', 'Repozitář se nepodařilo vytvořit');
			}

			if($this->checkFiles($files['file'])) {
				// sql parse
				$sqlParser = new FileRepositoryParser();
				foreach($files['file']['tmp_name'] as $file) {
					$sqlParser->addContent(file_get_contents($file));
				}
				//$this->model->insertSqlArtefactsNew($id, $sqlParser->getTables());
				foreach ($sqlParser->getTables() as $table) {
					$this->model->insertSqlArtefacts(array(':repository_id' => $id, ':type' => 'table', 'name' => $table));
				}
				if($id) {
					$this->addInfo('info', 'SQL bylo zpracováno');
				} else {
					$this->addInfo('error', 'SQL se nepodařilo zpracovat');
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