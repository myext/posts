<?php

define("DIR", __DIR__."/../");

require ( 'functions.php' );

spl_autoload_register('_autoload_');

Src\Db\DB::setConnect(
    [
        "db"   => config("db.name"),
        "user" => config("db.user"),
        "pass" => config("db.pass"),
    ]
);