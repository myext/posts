<?php

namespace Src\App\Actions;

use Src\App\Request;
use Src\App\Response;

class RedirectToFirstPageAction implements Middleware
{
    public function handle(Request $request, Middleware $next): Response
    {
        $response = $next->handle($request);

        if ($request->isAjax()) return $response;

        $response->setStatus(302);
        $response->setHeader([
            "HTTP/1.1 302 Found",
            "Location: /1"
        ]);

        return $response;
    }
}