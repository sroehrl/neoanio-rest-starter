<?php

namespace App\Auth\Middleware;

use Neoan\Errors\Unauthorized;
use Neoan\Routing\Routable;
use Neoan3\Apps\Stateless;

class RequiresLogin implements Routable
{

    public function __invoke(array $provided): array
    {
        try{
            return ['auth' => Stateless::validate()];
        } catch (\Exception $e) {
            new Unauthorized();
        }
    }
}