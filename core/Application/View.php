<?php

namespace Core\Application;

class View
{
    public function __construct(private readonly string $path, private array $options = [])
    {
    }

    public static function make(string $path, array $options = []) : static
    {
        return new static($path, $options);
    }

    public function __toString() : string
    {
        $value = $this->render();
        $hash_name = md5($this->getViewPath());

        $view_cache_dir = BASE_DIR . '/storage/views';

        $file_path = $view_cache_dir . '/' . $hash_name . '.php';

        file_put_contents($file_path, $value);

        return $value;
    }

    public function render() : string
    {
        extract($this->options);

        ob_start();
        include_once($this->getViewPath());
        $view_string = (string) ob_get_clean();
        return $view_string;
    }

    private function getViewPath() : string
    {
        return view_path($this->path . '.php');
    }
}