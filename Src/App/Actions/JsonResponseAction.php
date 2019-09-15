<?php

namespace Src\App\Actions;

use Src\App\Request;
use Src\App\Response;

use Src\Db\Post;

class JsonResponseAction implements Middleware
{

    public function handle( Request $request, Middleware $next) :Response
    {
        $response = $next->handle($request);

        if($request->isAjax()){

            $token = bin2hex(random_bytes(20));
            $_SESSION["CSRF"] = $token;
            $response->addData("CSRF", $token);

            $post = new Post(config("per_page"));

            $posts = $post->paginateWithBelong(1);

            if ($posts) $response->addData("posts", $posts);

            if(empty($response->getErrors())) {
                $response->setStatus(200);
                $response->setHeader(["HTTP/1.1 200 Ok"]);
            }
            else {
                $response->setStatus(4);
                $response->setHeader(["HTTP/1.1 422 Unprocessable Entity"]);
            }
            $response->addHeader("Content-Type: application/json");

            $response->setBody(json_encode($response->getAll()));
        }

        return $response;
    }
}