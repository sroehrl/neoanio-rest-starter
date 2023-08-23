<?php

namespace App\Auth\Support;

use App\User\Models\User;
use Neoan\Helper\DataNormalization;
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
        $parsed = new DataNormalization($user);
        return [
            'token' => Stateless::assign($identifier, $scope, $parsed->toArray())
        ];
    }
}