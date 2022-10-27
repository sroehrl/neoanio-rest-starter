<?php

namespace App\Auth\Support;

use App\User\Model\User;
use Neoan\Helper\Env;
use Neoan3\Apps\Stateless;

class GenerateJWT
{
    /**
     * @throws \Exception
     */
    public static function generate(User $user): array
    {
        $identifier = Env::get('APPLICATION_ID','SetThisIn.Env') . $user->id;
        $scope = ['full'];
        return [
            'token' => Stateless::assign($identifier, $scope, $user->toArray())
        ];
    }
}