<?php

namespace App\Auth\Routes;

use App\Auth\Error\Api404;
use App\Auth\Requests\ResetPasswordRequest;
use App\User\Model\User;
use App\User\Models\User;
use Neoan\Enums\RequestMethod;
use Neoan\Request\Request;
use Neoan\Routing\Attributes\Post;
use Neoan\Routing\Attributes\Put;
use Neoan\Routing\Interfaces\Routable;

#[Post('/api/auth/reset')]
#[Put('/api/auth/reset')]
class ResetPassword implements Routable
{
    public function __invoke(ResetPasswordRequest $request): array
    {
        $user = User::retrieveOne(['email' => $request->email, '^deletedAt']);
        if (!$user) {
            new Api404('User');
        }

        $requestOrUpdate = Request::getRequestMethod();
        $code = $user->updatedAt->stamp . date('d');
        if ($requestOrUpdate === RequestMethod::POST) {

        } else {

        }
        return ['name' => 'ResetPassword'];
    }
}