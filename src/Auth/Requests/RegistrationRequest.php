<?php

namespace App\Auth\Requests;

use Neoan\Request\RequestGuard;

class RegistrationRequest extends RequestGuard
{
    public string $email;
    public string $password;
}