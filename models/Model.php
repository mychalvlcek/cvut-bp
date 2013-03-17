<?php

class Model {
	private $info = array();
	private $isLogged;

	public function isLogged() {
		return $this->isLogged;
	}

	public function addInfo($level, $message) {
		$this->info[$level][] = $message;
	}
	public function getInfo() {
		return $this->info;
	}
}

?>