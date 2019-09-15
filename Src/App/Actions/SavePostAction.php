<?php

namespace Src\App\Actions;

use Src\App\Request;
use Src\App\Response;

use Src\Db\Post;
use Src\Db\User;

class SavePostAction implements Middleware
{

    public function handle( Request $request, Middleware $next) :Response
    {
        $response = $next->handle($request);

        if(empty($_SESSION['field_errors'])){
            $user = new User();
            $post = new Post();

            $id = $user->save($request->get("input"));
            //$_SESSION["user_id"] = $id;

            $post->user_id = $id;
            $post->save($request->get("input"));

            unset($_SESSION['field_errors']);
            unset($_SESSION['old']);
        }

        return $response;
    }

}