<?php

namespace Core\Http;

use Core\Application\Session;
use Core\Exceptions\Routing\RouteNotFoundException;
use Core\Exceptions\Validation\ValidationException;
use Core\Http\Routing\Router;

class Kernel
{

    public function __construct(
        private readonly Router $router,
    ) {

    }

    public function handle(Request $request) : void
    {
        try {
            $resolution = $this->router->resolve($request);

            $response = new Response($resolution);

            $response->send();

            Session::unflash();

        } catch (ValidationException $e) {
            Session::flash("_errors", $e->getValidationErrors());
            Session::flash("_old", $e->getOldValues());

            response()->back();
        } catch (RouteNotFoundException $e) {
            response()->notFound();
        }
    }
}