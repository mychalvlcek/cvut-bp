<?php
class Config
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

}

// db
Config::write('db.host', 'localhost');
Config::write('db.user', 'michalvlcek');
Config::write('db.password', 'SkeeFeET51wiNks');
Config::write('db.name', 'test');