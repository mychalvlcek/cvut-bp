<?php

class PagedUserListController { 
    private $viewModel; 

    public function __construct(PagedUserListViewModel $viewModel) { 
        $this->viewModel = $viewModel; 
    } 

    public function search($criteria) { 
        $this->viewModel->setCritera($criteria); 
    } 

    public function setPage($page) { 
        if (is_numeric($page)) { 
            $this->viewModel->setPage($page); 
        } 
    } 
}

?>