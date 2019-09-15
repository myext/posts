<?php

namespace Src\App\Actions;

use Src\App\Request;
use Src\App\Response;

class HttpRequestAction implements Middleware
{
    public function handle( Request $request, Middleware $next) :Response
    {
        $response = $next->handle($request);

        if($response->getStatus() == 200){
            $response->setHeader(["HTTP/1.1 200 Ok"]);
            $response->addHeader("Content-type: text/html; charset=UTF-8");

            extract($response->getData()["posts"]);

            if($request->has("input.old")){
                $old = $request->get("input.old");
                unset($_SESSION['old']);
            }
            if($request->has("input.field_errors")){
                $errors = $request->get("input.field_errors");
                unset($_SESSION['field_errors']);
            }

            $token = bin2hex(random_bytes(20));
            $_SESSION["CSRF"] = $token;

            ob_start();

            include (DIR.config("views").'index.php');

            $response->setBody( ob_get_contents());

            ob_end_clean();
        }

        return $response;
    }

}