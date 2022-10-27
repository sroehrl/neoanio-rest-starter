<?php

namespace App\Example\Api;

use App\Auth\Middleware\RequiresLogin;
use Neoan\Request\Request;
use Neoan\Routing\Attributes\Delete;
use Neoan\Routing\Attributes\Get;
use Neoan\Routing\Attributes\Post;
use Neoan\Routing\Attributes\Put;
use Neoan\Routing\Routable;

#[Get('/api/example/:parameter*')]
#[Post('/api/example/:parameter*')]
#[Put('/api/example/:parameter*')]
#[Delete('/api/example/:parameter*', RequiresLogin::class)]
class Example implements Routable
{
    public function __invoke(array $provided): array
    {
        return [
            'description' => 'This endpoint returns whatever you provide',
            'method' => Request::getRequestMethod(),
            'payload' => Request::getInputs(),
            'query' => Request::getQueries(),
            'parameter' => Request::getParameter('parameter')
        ];
    }
}