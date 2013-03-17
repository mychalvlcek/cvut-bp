<?php

class BlogModel { 
	private $db; 
	 
	public function __construct(Db $db) { 
		$this->db = $db; 
	} 

	public function findByTitle($title) { 
		//Find the selected blogs. 
		return $this->db->query('SELECT * FROM blogs WHERE title like :title', array(':title', $title); 
	} 

}

?>