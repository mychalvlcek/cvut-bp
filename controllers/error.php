<?php

Class errorController extends AbstractController {

    function index() {
    	$this->registry->template->title = 'Err';
        $this->registry->template->show('index');
    }

    function err404() {
    	$this->registry->template->title = '404 Err';
        $this->registry->template->show('404');
    }
}
?>