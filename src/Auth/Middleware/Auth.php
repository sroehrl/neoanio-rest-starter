<?php

namespace App\Auth\Middleware;

use Neoan\Routing\Interfaces\Routable;
use Neoan3\Apps\Stateless;

class Auth implements Routable
{
    private ?array $auth;
    public function __invoke(): self
    {
        try{
            $this->auth = Stateless::validate();
        } catch (\Exception $e) {
            $this->auth = null;
        }
        return $this;
    }
    public function get(): ?array
    {
        return $this->auth;
    }
    public function getUser(): ?array
    {
        if(!$this->auth){
            return null;
        }
        $user = [];
        [
            'id' => $user['id'],
            'email' => $user['email'],
            'createdAt' => $user['createdAt']
        ] = $this->auth;
        return $user;
    }
}