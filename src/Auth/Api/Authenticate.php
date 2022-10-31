<?php

namespace App\Auth\Api;

use App\Auth\Support\GenerateJWT;
use App\User\Model\User;
use Neoan\Provider\Injections;
use Neoan\Request\Request;
use Neoan\Routing\Attributes\Post;
use Neoan\Routing\Interfaces\Routable;

#[Post('/api/auth/authenticate')]
class Authenticate implements Routable
{
    /**
     * @throws \Exception
     */
    public function __invoke(Injections $provided): array
    {
        [
            'email' => $email,
            'password' => $password
        ] = Request::getInputs();
        $user = User::login($email, $password);
        return GenerateJWT::generate($user);
    }
}