<?php

function class_autoload($className) {
	$fileName = $className.'.php';
	$path = 'classes/'.$fileName;
	if (file_exists($path)) {
		include_once($path);
	} else {
		//throw new Exception("$fileName not found");
	}
}

function component_autoload($className) {
	$fileName = $className.'.php';
	$path = $fileName;
	if (file_exists('models/'.$path)) {
		include_once('models/'.$path);
	} else if (file_exists('controllers/'.$path)) {
		include_once('controllers/'.$path);
	} else if (file_exists('views/'.$path)) {
		include_once('views/'.$path);
	} else {
		//throw new Exception("$fileName not found");
	}
}

spl_autoload_register('class_autoload');
spl_autoload_register('component_autoload');

?>