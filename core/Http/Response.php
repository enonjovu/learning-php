<?php

namespace Core\Http;

class Response
{
    public function __construct(
        private readonly ?string $content = null,
        private int $status = 200,
        private array $headers = []
    ) {
    }

    public function send() : void
    {
        echo $this->content;
    }

    public function notFound()
    {
        $this->view("pages/errors/404");
        exit();
    }

    public function back()
    {
        $this->redirect(request()->previousUrl());
        exit();
    }

    public function redirect(string $path)
    {
        header("location: $path");
        exit();
    }

    public function view(string $path)
    {
        echo view($path);
    }
}