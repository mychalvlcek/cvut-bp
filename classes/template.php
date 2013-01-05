<?php

Class Template {

	// slouzi jako globalni kontext
	private $registry;
	// moje vlastni hodnoty (klic=>hodnota)
	private $vars = array();

	// konstruktor
	function __construct($registry) {
		$this->registry = $registry;
	}

	// pouzijeme settery a gettery
	public function __set($key, $value) {
		$this->vars[$key] = $value;
	}

	public function __get($key) {
		return $this->vars[$key];
	}


	function show($name, $layout = "layout") {
		// zverejneni promennych, neni to moc hezke, ale funguje to
		foreach ($this->vars as $key => $value){
			$$key = $value;
		}
		// kontrola zda existuje view
		$viewfile=VIEWSDIR.$this->registry->router->getController()."/".$name.".php";
		if($layout != null) $layout=VIEWSDIR.$layout.".php";
		if (is_readable($viewfile)) {
			ob_start();
			include $viewfile;
			$template_body =  ob_get_contents();
			ob_end_clean();
			if($layout != null) include $layout; else echo $template_body;
		} else {
			throw new Exception('Pohled neexistuje');
		}
	}
	
}

?>