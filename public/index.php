<?php

ini_set('error_reporting', E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



require(__DIR__."/../Src/boot.php");

session_start();

$request = new \Src\App\Request();

$router = new \Src\App\Router( $request, require ( DIR."Src/routes/web.php" ));

$route = $router->match();

try {
    $response = $route->run();
}

catch( Exception $e ){

    //do something with Exception, log or othere...

    header("HTTP/1.1 500 Internal Server Error");

    include (DIR.config("views").'500.php');

    exit();
}

$render = new \Src\App\Render($response);

$render->flush();



