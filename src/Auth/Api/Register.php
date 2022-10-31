<?php

namespace App\Auth\Api;

use App\Auth\Support\GenerateJWT;
use App\User\Model\User;
use Neoan\Provider\Injections;
use Neoan\Request\Request;
use Neoan\Response\Response;
use Neoan\Routing\Attributes\Post;
use Neoan\Routing\Interfaces\Routable;

#[Post('/api/auth/register')]
class Register implements Routable
{
    public function __invoke(Injections $provided): array
    {
        try{
            $user = new User(Request::getInputs());
            $user->store();
            return GenerateJWT::generate($user);
        } catch (\Exception $e) {
            Response::setStatusCode(422);
            return [
                'error' => 'Wrong format or user exists'
            ];
        }
    }
}