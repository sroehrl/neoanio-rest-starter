<?php

namespace App\Auth\Api;

use App\Auth\Middleware\RequiresLogin;
use Neoan\Provider\Injections;
use Neoan\Routing\Attributes\Get;
use Neoan\Routing\Interfaces\Routable;

#[Get('/api/auth/me', RequiresLogin::class)]
class Me implements Routable
{
    public function __invoke(Injections $provided): array
    {
        return $provided->get('auth', null);
    }
}