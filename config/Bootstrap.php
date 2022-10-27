<?php

namespace Config;

use Neoan\NeoanApp;
use Neoan\Render\Renderer;

class Bootstrap
{
    public function __construct(NeoanApp $app)
    {
        Renderer::setTemplatePath('src/');
        new Database();
        new Authentication();
    }
}