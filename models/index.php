<?php

class indexModel {

	public static function getAll() {
		global $db;
		$db->query("SELECT * FROM `users`;");
		return $db->resultSet();
	}

}

?>