<?php

namespace Config;

class Authentication
{
    public function __construct()
    {
        \Neoan3\Apps\Stateless::setSecret(\Neoan\Helper\Env::get('JWT_SECRET'));
    }
}