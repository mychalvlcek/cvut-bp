<?php

class Router {

	private $controller;
	private $action;
	private $id;
	private $file;
	// registry je parametr predavany v konstruktoru a je to vlastne sada klicu a hodnot (pole zabalene v tride Registry).
	// je to dobre pro predavani globalnich informaci mezi komponentami MVC
	private $registry;

	public function __construct(Registry $registry) {
		$this->registry = $registry;
	}

	// tato metoda provede vlastni routovani na zaklade ziskanych parametru
	public function route() {

		// zjistime si, co od nas kdo chce
		$this->getControllerInfo();

		//overime, zda dany controller existuje
		if (!is_readable(CONTROLLERSDIR.$this->file)) {
			$this->file = 'error.php';
			$this->controller = 'error';
			$this->action = 'err404';
		}

		// include controlleru
		include CONTROLLERSDIR.$this->file;
		//include helperu
		if (file_exists(HELPERSDIR.$this->file)) include HELPERSDIR.$this->file;

		// vyrobeni instance controlleru
		$class = $this->controller . 'Controller';
		$controller = new $class($this->registry);

		// ted zjistime, jestli tento controller ma pozadovanou akci, tedy metodu
		// a pokud ne, zavolame metodu (tedy akci) index
		if (method_exists($controller, $this->action)){
			$action = $this->action;
		} else {
			$action = 'index';
		}

		// zavolame danou metodu daneho controlleru
		$controller->$action();
	}

	// metoda vezme parametr rt a zjisti z nej akci a dalsi parametry
	// vysledky ve forme naplnenych instancnich promennych $controller, $file, $action
	protected function getControllerInfo() {
		@$rt=strtolower($_GET["rt"]);
		$parts = explode("/", $rt);
		if ($parts[0]=="") $this->controller = "index"; else $this->controller = $parts[0];
		if (@$parts[1]=="") $this->action = "index"; else $this->action = $parts[1];
		if (@$parts[2]=="") $this->id = null; else $this->id = $parts[2];
		$this->file = $this->controller.".php";
	}
	
	function getController() {
		return $this->controller;
	}
	
	function getAction() {
		return $this->action;
	}
	
	function getId() {
		return $this->id;
	}
}



?>