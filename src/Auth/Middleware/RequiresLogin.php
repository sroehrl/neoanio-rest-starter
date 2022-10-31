<?php

namespace App\Auth\Middleware;

use Neoan\Errors\Unauthorized;
use Neoan\Provider\Injections;
use Neoan\Routing\Interfaces\Routable;
use Neoan3\Apps\Stateless;

class RequiresLogin implements Routable
{

    public function __invoke(Injections $provided): void
    {
        try{
            $provided(['auth' => Stateless::validate()]);
        } catch (\Exception $e) {
            new Unauthorized();
        }
    }
}