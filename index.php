<?php

error_reporting(E_ALL);

require('config.php');
require('bootstrap.php');

$db = Database::getInstance();

// registry predstavuje globalni kontext
$registry = new Registry();

// vyrobime view templatovaci engine
$template = new Template($registry);
// pridame ho do globalniho kontextu
$registry->template = $template;

// vyrobime router
$router = new Router($registry);
// pridame ho do globalniho kontextu
$registry->router = $router;

$router->route();
	
?>