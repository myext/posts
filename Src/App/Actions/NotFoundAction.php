<?php

namespace Src\App\Actions;


use Src\App\Request;
use Src\App\Response;

class NotFoundAction implements Middleware
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function handle( Request $request, Middleware $next) :Response
    {
        $this->response->setStatus(404);
        $this->response->setHeader([
            "HTTP/1.1 404 Not Found",
        ]);

        ob_start();

        include (DIR.config("views").'404.php');

        $body = ob_get_contents();

        ob_end_clean();

        $this->response->setBody($body);

        return $this->response;
    }

}