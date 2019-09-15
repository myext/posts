<?php

namespace Src\App\Actions;


use Src\Db\Post;
use Src\App\Request;
use Src\App\Response;


class GetPostsAction implements Middleware
{
    public function handle( Request $request, Middleware $next) :Response
    {
        $response = $next->handle($request);


        $uri = $request->get("REQUEST_URI");
        $page = array_pop(explode("/", $uri));

        $post = new Post(config("per_page"));

        $posts = $post->paginateWithBelong($page);

        if ($posts){
            $response->setData(["posts" => $posts]);
            $response->setStatus(200);
        }

        return $response;
    }

}