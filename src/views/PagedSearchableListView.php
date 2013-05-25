<?php

class PagedSearchableListView extends View {

	public function __construct($route, Listable $model, Template $template) {
		parent::__construct($route, $model, $template);
	}

	public function output() {
		$this->template->set('html_title', $this->model->getEntityName());
		$this->template->set('criterium', $this->model->getCriteria());

		$data = $this->model->getData();
		$this->template->set('data', $data);
		if(!count($data)) {
			$this->template->set('noresults', 1);
		}
		$recordCount = $this->model->getRecordsCount();
		$recordsPerPage = $this->model->getRecordsPerPage();

		$pagination = $this->pagination($recordCount, $recordsPerPage, isset($_GET['page'])?$_GET['page']:1);
		$this->template->set('pagination', $pagination);

		return $this->template->output();
	}
}

?>