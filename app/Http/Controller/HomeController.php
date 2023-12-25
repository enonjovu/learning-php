<?php

namespace App\Http\Controller;

use App\Model\User;
use Core\Application\View;
use Core\Database\Connection;
use Core\Http\Request;

class HomeController
{
    public function __construct(
        private readonly Request $request,
    ) {
    }

    public function index()
    {
        return View::make('pages/index');
    }

}