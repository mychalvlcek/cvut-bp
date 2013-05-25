<?php

// development mode
Config::set('development', false);

Config::set('path', $_SERVER['DOCUMENT_ROOT'].'/');

// db config
Config::set('db_driver', 'mysql'); // MySQL => 'mysql', PostgreSQL => 'pgsql', ORACLE => 'oci'
Config::set('db_host', 'localhost');
Config::set('db_user', 'root');
Config::set('db_password', 'root');
Config::set('db_name', 'bp');

?>