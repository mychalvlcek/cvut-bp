<?php

class PagedListView extends View {

	public function __construct($route, Listable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$this->template->set('html_title', $this->model->getEntityName());

		$recordCount = $this->model->getRecordsCount();
		$recordsPerPage = $this->model->getRecordsPerPage();

		$pagination = $this->pagination($recordCount, $recordsPerPage, isset($_GET['page'])?$_GET['page']:1);
		$this->template->set('pagination', $pagination);

		$data = $this->model->getData(1);
		$this->template->set('data', $data);
		if(!count($data)) {
			$this->template->set('noresults', 1);
		}
		$criterium = $this->model->getCriteria();
		if($criterium != '') {
			$this->template->set('criterium', $criterium);
		}
		return $this->template->output();
	}
}

?>