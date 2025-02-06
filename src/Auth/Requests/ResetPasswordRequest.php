<?php

namespace App\Auth\Requests;

use Neoan\Request\RequestGuard;

class ResetPasswordRequest extends RequestGuard
{
    public ?string $password = null;

    public ?string $email = null;

    public ?string $code = null;

}