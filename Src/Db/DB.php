<?php

namespace Src\Db;

use \PDO;


class DB
{
    protected static $pdo = null;
    protected static $connect = [
        "ds" => 'mysql',
        "host" => 'localhost',
        "db"   => '',
        "user" => '',
        "pass" => '',
        "charset" => 'utf8',
    ];

    protected static $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    public static function setConnect( array $data )
    {
        self::$connect = array_merge( self::$connect, $data );
    }

    public static function getDbName()
    {
        return self::$connect["db"];
    }

    public static function getPDO ()
    {
        if(self::$pdo) return self::$pdo;

        $connect = self::$connect;

        $dsn = "{$connect['ds']}:host={$connect['host']};dbname={$connect['db']}";

        self::$pdo = new \PDO(
            $dsn,
            self::$connect["user"],
            self::$connect["pass"],
            self::$options);

        return self::$pdo;
    }

    private function __construct()
    {
    }

    protected function __clone()
    {
    }
}