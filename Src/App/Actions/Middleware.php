<?php

namespace Src\App\Actions;

use Src\App\Request;
use Src\App\Response;

interface Middleware
{
    public function handle( Request $request, Middleware $next) : Response;
}