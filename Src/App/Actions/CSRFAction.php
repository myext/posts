<?php

namespace Src\App\Actions;

use Src\App\Request;
use Src\App\Exception\CSRFException;
use Src\App\Response;


class CSRFAction implements Middleware
{
    public function handle( Request $request, Middleware $next) :Response
    {
        $response = $next->handle($request);

        if( $request->has("input.CSRF") &&
            $request->get("REQUEST_METHOD") == "POST" &&
            (!$request->has("input.csrfToken") or
            $request->get("input.CSRF") !== $request->get("input.csrfToken"))) {

            throw new CSRFException();
        }

        return $response;
    }

}