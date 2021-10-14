<?php


class Db
{
    private static $connection = null;

    public static function getConnection()
    {
        if(!self::$connection) {
            self::$connection = new PDO('sqlite:database/db.sqlite');
        }
        return self::$connection;
    }
}