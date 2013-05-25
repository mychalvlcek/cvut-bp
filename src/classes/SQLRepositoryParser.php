<?php

class SQLRepositoryParser {
	private $content;
	private $tables = array();
	private $columns = array();

	public function __construct() {
		$this->content = '';
	}

	public function addContent($content) {
		$this->content .= $content;
	}

	public function parse() {
		if(preg_match_all('#CREATE TABLE[^`]*`(?P<table>\w+)`|`(?P<column>\w+)`#', $this->content, $matches)) {
			$this->tables = array_filter(array_unique($matches['table']));
			$this->columns = array_filter(array_unique($matches['column']));
		}
	}
	public function getTables() {
		return $this->tables;
	}

	public function getColumns() {
		return $this->columns;
	}
	
}

?>