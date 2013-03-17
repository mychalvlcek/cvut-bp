<?php

// development mode
Config::set('development', true);

Config::set('path', $_SERVER['DOCUMENT_ROOT'].'/');

Config::set('abs_path', '/var/www/clients/client11/web238/');

// db config
Config::set('db_driver', 'mysql'); // MySQL => 'mysql', PostgreSQL => 'pgsql', ORACLE => 'oci'
Config::set('db_host', 'localhost');
Config::set('db_user', 'root');
Config::set('db_password', 'root');
Config::set('db_name', 'bp');

?>