<?php

namespace App\Auth\Routes;

use App\Auth\Requests\LoginRequest;
use App\Auth\Support\GenerateJWT;
use App\User\Models\User;
use Neoan\Request\Request;
use Neoan\Routing\Attributes\Post;
use Neoan\Routing\Interfaces\Routable;

#[Post('/api/auth/authenticate')]
class Authenticate implements Routable
{
    /**
     * @throws \Exception
     */
    public function __invoke(LoginRequest $request): array
    {

        $user = User::login($request->email, $request->password);
        return GenerateJWT::generate($user);
    }
}