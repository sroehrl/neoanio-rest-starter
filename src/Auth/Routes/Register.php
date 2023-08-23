<?php

namespace App\Auth\Routes;

use App\Auth\Requests\RegistrationRequest;
use App\Auth\Support\GenerateJWT;
use App\User\Models\User;
use Neoan\Request\Request;
use Neoan\Response\Response;
use Neoan\Routing\Attributes\Post;
use Neoan\Routing\Interfaces\Routable;

#[Post('/api/auth/register')]
class Register implements Routable
{
    public function __invoke(RegistrationRequest $request): array
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