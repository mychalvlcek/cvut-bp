<?php

class Config {
	private static $cfg;

	public static function read($name) {
		return self::$cfg[$name];
	}

	public static function write($name, $value) {
		self::$cfg[$name] = $value;
	}

}

?>