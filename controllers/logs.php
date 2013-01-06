<?php

class logsController extends AbstractController {

	function index() {
		$this->registry->template->title = 'Modul pro srovnání textu skriptu';
		$this->registry->template->show('index');
	}

}

?>