<?php

use Core\Application\Application;
use Core\Application\Session;
use Core\Application\View;
use Core\Http\Request;
use Core\Http\Response;
use Core\Support\Str;

function view_path(string $path) : string
{
    $path = BASE_DIR . '/resources/views/' . $path;

    if (! file_exists($path)) {
        throw new Exception("path $path does not exist");
    }

    return $path;
}

function request() : Request
{
    return application()->get(Request::class);
}

function asset_path(string $path) : string
{
    return request()->getHost() . $path;
}

function view(string $path, ?array $options = []) : View
{
    return View::make($path, $options);
}

function response(?string $content = null, int $status = 200, ?array $headers = []) : Response
{
    return new Response($content, $status, $headers);
}

function config(string $path)
{
    return require_once(BASE_DIR . '/config/' . $path . '.php');
}

function html(string $e) : string
{
    return htmlspecialchars($e);
}

function application() : Application
{
    return Application::create();
}

function old($key, $default = null) : mixed
{
    return Session::get("_old")[$key] ?? $default;
}

function validation_error_messages() : array
{
    return Session::get("_errors") ?? [];
}

function str(string $text)
{
    return new Str($text);
}