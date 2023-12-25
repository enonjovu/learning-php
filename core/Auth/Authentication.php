<?php

namespace Core\Auth;

use Core\Database\Connection;
use Core\Exceptions\Validation\ValidationException;

class Authentication
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function login(array $user)
    {
        $_SESSION['user'] = [
            'email' => $user['email']
        ];

        session_regenerate_id(true);
    }

    public function attempt(string $email, string $password)
    {
        $user = $this->connection->query('select * from users where email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login($user);

                return true;
            }
        }

        return false;
    }

    public function register(array $data) : void
    {
        $user = $this->connection->query('select * from users where email = :email', [
            'email' => $data['email']
        ])->find();

        if ($user) {
            ValidationException::create(['email' => "email already exists"]);
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $this->connection->query("insert into users(name,email,password) values(:name,:email,:password)", $data);

        $this->login([
            "email" => $data['email'],
            "password" => $data['password'],
        ]);
    }
}