<?php

class Config {
	private static $cfg;

	public static function get($name) {
		if(array_key_exists($name, self::$cfg))
			return self::$cfg[$name];
		return null;
	}

	public static function set($name, $value) {
		define(strtoupper($name), $value);
		self::$cfg[$name] = $value;
	}

}

?>