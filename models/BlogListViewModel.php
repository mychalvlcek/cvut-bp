<?php

class BlogListViewModel implements Listable { 
    private $model;
    private $title;
     
    public function __construct(BlogModel $model) { 
        $this->model = $model; 
    } 

    public function setCriteria($criteria) { 
        return $this->title = $criteria; 
    } 

}

?>