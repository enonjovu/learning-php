<?php

namespace Core\Http\Routing;

use Core\Exceptions\Routing\RouteNotFoundException;
use Core\Http\Request;
use Exception;

class RouteMatcher
{
    public function resolve(Request $request, array $routes = []) : ?Route
    {

        $path_filtered_routes = array_filter(
            $routes,
            fn (Route $route) => $this->matches($request, $route->getPath())
        );

        if (empty($path_filtered_routes)) {
            throw new RouteNotFoundException;
        }

        $path_filtered_routes = array_filter(
            $path_filtered_routes,
            fn (Route $route) => $route->getMethod() == $request->getMethod()
        );


        if (empty($path_filtered_routes)) {
            throw new Exception("405");
        }


        [$route] = array_values($path_filtered_routes);

        return $route;
    }

    private function matches(Request $request, string $route) : bool
    {
        $pattern = $this->formatRouteToRegex($route);

        return preg_match($pattern, $request->getPath(), $matches);
    }

    public static function formatRouteToRegex(string $route) : string
    {
        $pattern = str_replace('/', '\/', $route);
        $pattern = preg_replace('/\{(\w+)}/', '([^\/]+)', $pattern);
        return "/^$pattern$/";
    }
}