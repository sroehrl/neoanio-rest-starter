<?php

namespace App\Auth\Api;

use App\Auth\Middleware\RequiresLogin;
use Neoan\Routing\Attributes\Get;
use Neoan\Routing\Routable;

#[Get('/api/auth/me', RequiresLogin::class)]
class Me implements Routable
{
    public function __invoke(array $provided): array
    {
        return $provided['auth'];
    }
}