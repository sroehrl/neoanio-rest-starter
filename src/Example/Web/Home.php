<?php

namespace App\Example\Web;

use Neoan\Routing\Attributes\Web;
use Neoan\Routing\Routable;

#[Web('/', 'Example/Web/example.html')]
class Home implements Routable
{
    /**
     * @throws \Exception
     */
    public function __invoke(array $provided): array
    {
        return ['name' => 'Example Home controller'];
    }
}