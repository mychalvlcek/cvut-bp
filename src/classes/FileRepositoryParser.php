<?php

class FileRepositoryParser {
	private $content;

	public function __construct() {
		$this->content = '';
	}

	public function addContent($content) {
		$this->content .= $content;
	}
	/**
	 * CREATE TABLE IF NOT EXISTS `table`
	*/
	public function getTables() {
		preg_match_all('#CREATE TABLE[^`]*`(\w+)`#i', $this->content, $matches);
		return $matches[1];
	}

	public function getColumns() {
		preg_match_all('#CREATE TABLE[^`]*`(\w+)`#i', $this->content, $matches);
		return $matches[1];
	}

	public function getAnchors() {
		preg_match_all('#<a[^>]*>([^<]*)<\/a>#i', $this->content, $matches);
		return $matches[1];
	}
	
} 

?>