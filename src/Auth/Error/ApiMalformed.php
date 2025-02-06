<?php

namespace App\Auth\Error;

use Neoan\Helper\Terminate;
use Neoan\Response\Response;

class ApiMalformed
{
    public function __construct()
    {
        $response = new Response();
        http_response_code(400);
        $response->json(['msg' => 'Bad request']);
        Terminate::die();
    }
}