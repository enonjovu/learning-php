<?php

namespace App\Http\Middlewares;

use Core\Application\Session;
use Core\Http\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Illuminate\Contracts\Support\Responsable;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        if (! Session::has('_auth')) {
            response()->redirect("/auth/login");
        }
    }
}