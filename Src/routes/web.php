<?php

return [
    [
        "url" => '/^\/$/u',
        "method" => "GET",
        "route" =>
            function($request){return new \Src\App\Route( $request, [
                function (){return new \Src\App\Actions\RedirectToFirstPageAction();},
                function (){return new \Src\App\Actions\NotFoundAction();},
                ]);},
        ],

    [
        "url" => '/^\/\d+$/u',
        "method" => "GET",
        "route" =>
            function($request){return new \Src\App\Route($request, [
                function (){return new \Src\App\Actions\HttpRequestAction();},
                function (){return new \Src\App\Actions\GetPostsAction();},
                function (){return new \Src\App\Actions\NotFoundAction();},
            ]);},
    ],


    [
        "url" => "/^\/$/u",
        "method" => "POST",
        "route" =>
            function($request){return new \Src\App\Route($request, array(
                function (){return new \Src\App\Actions\RedirectToFirstPageAction();},
                function (){return new \Src\App\Actions\JsonResponseAction();},
                function (){return new \Src\App\Actions\SavePostAction();},
                function (){return new \Src\App\Actions\ValidatorAction();},
                function (){return new \Src\App\Actions\CSRFAction();},
                function (){return new \Src\App\Actions\NotFoundAction();},
            ));},
    ],
];

