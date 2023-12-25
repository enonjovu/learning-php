<?php

namespace App\Model;

use Core\Database\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct('users');
    }
}
