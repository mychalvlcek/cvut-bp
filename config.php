<?php

error_reporting(E_ALL);

// db
Config::write('db.engine', 'pgsql');
Config::write('db.host', 'localhost');
Config::write('db.port', '5432');
Config::write('db.basename', 'bp');
Config::write('db.user', 'postgres');
Config::write('db.password', 'postgres');

?>