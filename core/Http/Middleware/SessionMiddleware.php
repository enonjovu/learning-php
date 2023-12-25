<?php

namespace Core\Http\Middleware;

use Core\Http\Request;


class SessionMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        \Core\Application\Session::start();
    }
}