<?php
use App\Http\Controller\AuthenicationController;
use App\Http\Controller\HomeController;
use App\Http\Controller\NoteController;
use App\Http\Middlewares\AuthMiddleware;
use Core\Http\Routing\Router;


return function (Router $router) {
    $router->get("/", [HomeController::class, 'index'])
        ->middleware(AuthMiddleware::class);

    $router->get("/notes", [NoteController::class, 'index'])->middleware(AuthMiddleware::class);
    $router->post("/notes", [NoteController::class, 'store'])->middleware(AuthMiddleware::class);
    $router->get("/notes/create", [NoteController::class, 'create'])->middleware(AuthMiddleware::class);
    $router->get("/notes/{id}", [NoteController::class, 'show'])->middleware(AuthMiddleware::class);
    $router->delete("/notes/{id}", [NoteController::class, 'delete'])->middleware(AuthMiddleware::class);
    $router->put("/notes/{id}", [NoteController::class, 'update'])->middleware(AuthMiddleware::class);
    $router->get("/notes/{id}/edit", [NoteController::class, 'edit'])->middleware(AuthMiddleware::class);

    $router->view("/about", "pages/about");
    $router->view("/contact", "pages/contact");

    $router->get("/auth/login", [AuthenicationController::class, 'login']);
    $router->get("/auth/register", [AuthenicationController::class, 'register']);
    $router->post("/auth/authenticate", [AuthenicationController::class, 'authenticate']);
    $router->post("/auth/register", [AuthenicationController::class, 'store']);
};