<?php

namespace Core\Application;

use Core\Database\Connection;
use Core\Http\Kernel as HttpKernel;
use Core\Http\Request;
use Core\Http\Routing\Router;
use Illuminate\Container\Container;

class Application extends Container
{
    private Router $router;
    private HttpKernel $httpKernel;
    private static ?Application $applicationInstance = null;

    private function __construct()
    {
        $this->router = new Router($this);
        $this->httpKernel = new HttpKernel($this->router);
    }

    public static function create() : static
    {
        if (is_null(self::$applicationInstance)) {
            self::$applicationInstance = new static;
        }
        return self::$applicationInstance;
    }

    public function boot() : void
    {
        $this->bind(Request::class, fn () => Request::create());
        $this->bind(Connection::class, fn () => Connection::create(config('database')['driver']['mysql']));

        $routes = require_once(BASE_DIR . '/routes/web.php');
        $routes($this->router);
    }

    public function run() : void
    {
        $this->httpKernel->handle(Request::create());
    }

    public function getRouter() : Router
    {
        return $this->router;
    }

}