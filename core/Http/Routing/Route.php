<?php

namespace Core\Http\Routing;

use Core\Application\Application;
use Exception;

class Route
{
    private ?string $name = null;
    private array $middlewares = [];

    public function __construct(
        private readonly Application $application,
        private readonly string      $path,
        private readonly mixed       $action,
        private readonly ?string     $method = 'GET',
    )
    {
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function middleware(array|string $middleware): static
    {
        if (is_string($middleware)) {
            $this->middlewares[] = $middleware;
        }
        if (is_array($middleware)) {
            $this->middlewares = $this->middlewares + $middleware;
        }

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function resolveRouteAction()
    {
        if (is_callable($this->action)) {
            return call_user_func($this->action);
        }

        if (is_array($this->action)) {
            [$class, $method] = $this->action;

            if (!class_exists($class)) {
                throw new Exception("route action class $class::class does not exist");
            }

            $class = $this->application->get($class);

            if (!method_exists($class, $method)) {
                throw new Exception("route action method $method does not exist on $class::class}::class");
            }

            return call_user_func_array([$class, $method], $this->getRouteParameters());
        }

        throw new Exception("invalid route action");
    }

    private function getRouteParameters(): array
    {
        $pattern = RouteMatcher::formatRouteToRegex($this->path);

        preg_match_all($pattern, request()->getPath(), $matches);

        unset($matches[0]);

        return array_values(array_map(fn($value) => $value[0], $matches));
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function hasMiddleware(): bool
    {
        return !empty($this->middlewares);
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    private function hasRouteParameters(): bool
    {
        $pattern = RouteMatcher::formatRouteToRegex($this->path);

        return preg_match_all($pattern, request()->getPath(), $matches);
    }
}