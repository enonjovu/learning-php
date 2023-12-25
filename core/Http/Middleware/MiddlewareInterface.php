<?php

namespace Core\Http\Middleware;

use Core\Http\Request;
use Core\Http\Response;

interface MiddlewareInterface
{
    public function handle(Request $request);
}