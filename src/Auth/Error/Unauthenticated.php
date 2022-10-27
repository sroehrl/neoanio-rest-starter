<?php

namespace App\Auth\Error;

use Neoan\Helper\Terminate;
use Neoan\Response\Response;

class Unauthenticated
{
    public function __construct()
    {
        $response = new Response();
        http_response_code(403);
        $response->respond('Could not log in with these credentials');
        Terminate::die();
    }
}