<?php

namespace Core\Http;

use Core\Validation\Validation;

class Request
{


    public function __construct(
        private readonly array $getRequestParameters,
        private readonly array $postRequestParameters,
        private readonly array $request,
        private readonly array $cookies,
        private readonly array $files,
        private readonly array $server,
    ) {
    }

    public static function create() : static
    {
        return new static(
            getRequestParameters: $_GET,
            postRequestParameters: $_POST,
            request: $_REQUEST,
            cookies: $_COOKIE,
            files: $_FILES,
            server: $_SERVER
        );
    }

    public function getMethod() : string
    {
        if (array_key_exists('_method', $this->postRequestParameters)) {
            return strtoupper($this->postRequestParameters['_method']);
        }

        return $this->server['REQUEST_METHOD'];
    }

    public function getHost() : string
    {
        return 'http://' . $this->server['HTTP_HOST'];
    }

    public function is(string $path) : bool
    {
        return $this->getPath() == $path;
    }

    public function getPath() : string
    {
        return parse_url($this->getUri())['path'];
    }

    public function getUri() : string
    {
        return $this->server['REQUEST_URI'];
    }

    public function get(string $name) : mixed
    {
        return array_key_exists($name, $this->request) ? $this->request[$name] : null;
    }

    public function has(string $name) : bool
    {
        return (bool) $this->get($name);
    }

    public function only(array $fields) : array
    {
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $this->has($field) ? $this->get($field) : null;
        }

        return $data;
    }

    public function previousUrl() : ?string
    {
        return $this->server['HTTP_REFERER'] ?? null;
    }

    public function validate(array $rules) : array
    {
        $fields = $this->only(array_keys($rules));

        return Validation::create($fields, $rules)->validate();
    }
}