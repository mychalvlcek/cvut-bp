<?php

error_reporting();

class importController extends AbstractController {

	function index() {
		$this->registry->template->title = 'Modul pro srovnání textu skriptu';
		$this->registry->template->show('index');
	}

	function url() {
		if(isset($_POST['url'])) {
			$file = file_get_contents(trim($_POST['url']));
			if ( preg_match_all('#<a[^<]*<\/a>#i', $file, $matches) ) {
				$this->registry->template->anchors = implode(', ', $matches[0]);
			}
		} else {
			$this->registry->template->anchors = 'Žádné odkazy nebyli nalezeny.';
		}

		$this->registry->template->file = (isset($_POST['url']) && $_POST['url'] != ''?htmlspecialchars(file_get_contents(trim($_POST['url']))):'Zde bude zdrojový kód nahraného souboru.');
		$this->registry->template->title = 'Modul pro srovnání textu skriptu';
		$this->registry->template->show('url');
	}

}

?>