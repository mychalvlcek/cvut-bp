<?php

function core_class_autoload($className) {
    $fileName = $className.'.php';
    $path = 'src/classes/'.$fileName;
    if (file_exists($path)) {
        include_once($path);
    } else {
        //throw new Exception("$fileName not found");
    }
}

function component_class_autoload($className) {
    $fileName = $className.'.php';
    $path = $fileName;
    if (file_exists('src/models/'.$path)) {
        include_once('src/models/'.$path);
    } else if (file_exists('src/controllers/'.$path)) {
        include_once('src/controllers/'.$path);
    } else if (file_exists('src/views/'.$path)) {
        include_once('src/views/'.$path);
    } else {
        throw new Exception("$fileName not found");
    }
}

spl_autoload_register('core_class_autoload');
spl_autoload_register('component_class_autoload');

?>