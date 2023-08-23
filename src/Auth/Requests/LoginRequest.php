<?php

namespace App\Auth\Requests;

use Neoan\Request\RequestGuard;

class LoginRequest extends RequestGuard
{
    public string $email;
    public string $password;
}