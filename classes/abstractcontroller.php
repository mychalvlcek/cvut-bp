<?php

Abstract Class AbstractController {
	//registry si budeme pamatovat ve vsech komponentach MVC
	protected $registry;
	function __construct(Registry $registry) {
	$this->registry = $registry;
	}
	//vsechny tridy typu controller musi obsahovat akci index
	abstract function index();
}

?>