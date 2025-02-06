<?php

namespace App\Auth\Error;

use Neoan\Helper\Terminate;
use Neoan\Response\Response;

class ApiUniqueError
{
    public function __construct()
    {
        $response = new Response();
        http_response_code(400);
        $response->respond('Entity is not unique ');
        Terminate::die();
    }
}