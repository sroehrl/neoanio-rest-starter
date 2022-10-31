<?php

namespace App\Example\Web;

use Neoan\Provider\Injections;
use Neoan\Routing\Attributes\Web;
use Neoan\Routing\Interfaces\Routable;

#[Web('/', 'Example/Web/example.html')]
class Home implements Routable
{
    /**
     * @throws \Exception
     */
    public function __invoke(Injections $provided): array
    {
        return ['name' => 'Example Home controller'];
    }
}