<?php

// tato trida slouzi k uchovavani dat pro pouziti ve view
Class Registry {

	// pole klicu a hodnot
	private $vars = array();


	// pouzijeme setter a gettery
	// setter
	public function __set($index, $value) {
		$this->vars[$index] = $value;
	}

	// getter
	public function __get($index) {
		return $this->vars[$index];
	}

}

?>