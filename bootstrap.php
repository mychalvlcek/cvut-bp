<?php

define ("CLASSDIR", "classes/");
define ("CONTROLLERSDIR", "controllers/");
define ("HELPERSDIR", "helpers/");
define ("VIEWSDIR", "views/");
define ("MODELSDIR", "models/");
define ("DIRNAME", "/");
define ("STYLEFILE", "styles/style.css");

function __autoload($classname) {
    $filename = strtolower($classname.".php");
    include(CLASSDIR.$filename);
}

?>