<?php
use Core\Application\Application;

const BASE_DIR = __DIR__;

require_once __DIR__ . '/vendor/autoload.php';

$app = application();

$app->boot();

return $app;