<?php

namespace App\Http\Controller;

use Core\Auth\Authentication;
use Core\Database\QueryBuilder;
use Core\Exceptions\Validation\ValidationException;
use Core\Http\Request;
use Core\Validation\Validation;

class AuthenicationController
{
    public function __construct(
        private Authentication $authentication,
        private Request $request,
        private QueryBuilder $queryBuilder
    ) {
    }

    public function login()
    {
        $notes = $this->queryBuilder->table("notes")->get();

        dd($notes);

        return view("pages/auth/login");
    }

    public function register()
    {
        return view("pages/auth/register");
    }

    public function authenticate()
    {
        $user = request()->validate([
            "email" => ["required", "email"],
            "password" => ["required", "string"],
        ]);

        if (! $this->authentication->attempt($user['email'], $user['password'])) {
            ValidationException::create(['email' => "No matching account found for that email address and password."]);
        }

        return response()->redirect("/");
    }

    public function store()
    {
        $userData = $this->request->validate([
            "name" => ["string", "required"],
            "password" => ["string", "required"],
            "email" => ["email", "required"],
        ]);


        $this->authentication->register($userData);

        return response()->redirect("/");
    }
}