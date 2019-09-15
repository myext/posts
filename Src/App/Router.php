<?php

namespace Src\App;


class Router
{
    protected $routes;
    protected $request;

    public function __construct( Request $request, $routes = [] )
    {
        $this->routes = $routes;
        $this->request = $request;
    }

    public function match()
    {
        foreach ($this->routes as $route){

            if( $route["method"] == $this->request->get("REQUEST_METHOD") &&
                preg_match($route["url"], $this->request->get("REQUEST_URI"))) {

                return $route["route"]($this->request);
            }
        }

        return new \Src\App\Route($this->request, [
            function (){return new \Src\App\Actions\NotFoundAction();},
        ]);

    }
}