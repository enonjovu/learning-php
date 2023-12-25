<?php

namespace Core\Http\Routing;

use Core\Application\Application;
use Core\Http\Request;

class Router
{
    private array $routes = [];

    private array $GLOBAL_MIDDLEWARES = [
        \Core\Http\Middleware\SessionMiddleware::class,
    ];

    public function __construct(
        private readonly Application $application,
    ) {
    }

    public function post(string $path, mixed $action) : Route
    {
        return $this->addRoute($path, $action, "POST");
    }

    private function addRoute(string $path, mixed $action, string $method = "GET") : Route
    {
        $newRoute = new Route($this->application, $path, $action, $method);
        $this->routes[] = $newRoute;
        return $newRoute;
    }

    public function delete(string $path, mixed $action) : Route
    {
        return $this->addRoute($path, $action, "DELETE");
    }

    public function put(string $path, mixed $action) : Route
    {
        return $this->addRoute($path, $action, "PUT");
    }

    public function patch(string $path, mixed $action) : Route
    {
        return $this->addRoute($path, $action, "PATCH");
    }

    public function view(string $path, string $view) : Route
    {
        return $this->addRoute($path, fn () => view($view));
    }

    public function resolve(Request $request) : mixed
    {
        $route = (new RouteMatcher)
            ->resolve($request, $this->routes);

        $this->runGlobalMiddlewares($request);

        if ($route->hasMiddleware()) {
            $middlewares = $route->getMiddlewares();
            foreach ($middlewares as $middleware) {
                $this->application->get($middleware)->handle($request);
            }
        }

        return $route->resolveRouteAction();
    }

    private function runGlobalMiddlewares(Request $request) : void
    {
        foreach ($this->GLOBAL_MIDDLEWARES as $middleware) {
            $this->application->get($middleware)->handle($request);
        }
    }

    public function get(string $path, mixed $action) : Route
    {
        return $this->addRoute($path, $action);
    }
}