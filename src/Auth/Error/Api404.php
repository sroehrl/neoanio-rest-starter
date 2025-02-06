<?php

namespace App\Auth\Error;

use Neoan\Helper\Terminate;
use Neoan\Response\Response;

class Api404
{
    public function __construct(string $entityName)
    {
        $response = new Response();
        http_response_code(404);
        $response->json(['msg' =>'Could not find ' . $entityName]);
        Terminate::die();
    }
}