<?php

error_reporting();

include_once('models/index.php');

class logsController extends AbstractController {

	function index() {

		$names = indexModel::getAll();
		$this->registry->template->names = $names;

		$this->registry->template->title = 'Modul pro srovnání textu skriptu';
		$this->registry->template->show('index');
	}

}

?>