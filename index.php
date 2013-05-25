<?php

session_start();

error_reporting(E_ALL);

include_once('bootstrap.php');
include_once('cfg.php');

Logger::start(DEVELOPMENT);

$frontController = new FrontController(new Router());
$frontController->route(isset($_GET['rt'])?$_GET['rt']:'');

echo $frontController->output();

?>