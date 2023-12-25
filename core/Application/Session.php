<?php

namespace Core\Application;

class Session
{
    public static function start() : void
    {
        if (! session_status() == PHP_SESSION_NONE) {
            return;
        }

        session_start();
    }

    public static function put(string $key, mixed $data) : void
    {
        $_SESSION[$key] = $data;
    }

    public static function get(string $key) : mixed
    {
        return $_SESSION['_flashed'][$key] ?? $_SESSION[$key] ?? null;
    }

    public static function has(string $key)
    {
        return ! is_null($_SESSION[$key]);
    }

    public static function flash(string $key, mixed $data) : void
    {
        $_SESSION['_flashed'][$key] = $data;
    }

    public static function unflash() : void
    {
        unset($_SESSION["_flashed"]);
    }
}