<?php

class PaginationView { 
    private $model; 
    private $template; 

    public function __construct(Pageable $model, Template $template) { 
        $this->model = $model; 
        $this->template = $template; 
    } 

    public function output() { 
        $perPage = $this->model->getRecordsPerPage(); 
        $pageNo = $this->model->getCurrentPage(); 

        if (empty($pageNo) || !is_numeric($pageNo) || $pageNo < 1) $pageNo = 1; 
        $result = $this->viewModel->find($perPage, ($pageNo-1)*$perPage); 

        $totalRecords = $this->model->getTotalResults(); 
        $totalPages = ceil($totalRecords/$perPage); 

        for ($i = 1; $i <= $totalPages; $i++)
        	$this->template->appendSection('page', array('num' => $i, 'class' => $i == $pageNo ? $this->currentClass : '')); 

         
        foreach ($result as $record)
        	$this->template->appendSection('record', $record); 
         
        return $this->template->output(); 
         
    } 
}

?>