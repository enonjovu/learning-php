<?php

namespace Core\Support;

class Str
{
    public function __construct(private string $text)
    {
    }

    public function contains(string $search) : bool
    {
        return str_contains($this->text, $search);
    }

    public function replace(array $replace)
    {
        foreach ($replace as $key => $value) {
            $this->text = str_replace($key, $value, $this->text);
        }
        return $this;
    }

    public function __toString()
    {
        return $this->text;
    }
}
