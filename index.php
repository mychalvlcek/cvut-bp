<?php

error_reporting(E_ALL);

include_once('bootstrap.php');
include_once('cfg.php');

Logger::start(DEVELOPMENT);
$frontController = new FrontController(new Router(), isset($_GET['route']) ? $_GET['route'] : 'home', isset($_GET['action']) ? $_GET['action'] : null); 
echo $frontController->output();

?>