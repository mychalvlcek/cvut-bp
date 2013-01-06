<?php

include_once('models/index.php');

class indexController extends AbstractController {

	function index() {
		$users = indexModel::getAll();
		$this->registry->template->users = $users;
		
		$this->registry->template->title = 'Modul pro srovnání textu skriptu';
		$this->registry->template->show('index');
	}

}

?>