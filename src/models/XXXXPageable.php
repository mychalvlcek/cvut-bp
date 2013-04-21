<?php

interface Pageable { 
    //Get the records using limit and offset 
    public function find($limit, $offset); 
     
    //The number of records which will be shown on each page 
    public function getRecordsPerPage(); 
     
    //The page currently being shown 
    public function getCurrentPage(); 
     
    //The total number of records being paged through. 
    //Used to calculate the total number of pages. 
    public function getTotalResults(); 
} 

?>