<?php

namespace App\Auth\Api;

use App\Auth\Middleware\Auth;
use App\Auth\Middleware\RequiresLogin;
use Neoan\Routing\Attributes\Get;
use Neoan\Routing\Interfaces\Routable;

#[Get('/api/auth/me', RequiresLogin::class)]
class Me implements Routable
{
    public function __invoke(Auth $auth): array
    {
        return $auth->getUser();
    }
}