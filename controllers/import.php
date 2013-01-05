<?php

error_reporting();

class importController extends AbstractController {

	function index() {

		$this->registry->template->title = 'Modul pro srovnání textu skriptu';
		$this->registry->template->show('index');
	}

	function url() {
		$this->registry->template->file = (isset($_POST['url'])?htmlspecialchars(file_get_contents(trim($_POST['url']))):'');
		$this->registry->template->title = 'Modul pro srovnání textu skriptu';
		$this->registry->template->show('url');
	}

}

?>