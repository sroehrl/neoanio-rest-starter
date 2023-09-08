<?php

namespace App\Example\Routes;

use Neoan\Request\Request;
use Neoan\Routing\Attributes\Web;
use Neoan\Routing\Interfaces\Routable;
use Neoan3\Apps\Template\Constants;
use Neoan3\Apps\Template\Template;

#[Web('/', 'Example/Views/home.html')]
class Home implements Routable
{
    /**
     * @throws \Exception
     */
    public function __invoke(): array
    {
        $this->setupForWeb();
        return [
            'content' => Request::getQuery('view') ?? 'api',
            'name' => 'Example/Routes/Home.php'
        ];
    }
    /*
     * This is an API setup, so we are going to run web setup only in this controller
     * */
    private function setupForWeb(): void
    {
        Constants::addCustomAttribute('partial', function(\DOMAttr $attr, $info = []){
            $attr->parentNode->nodeValue =  Template::embraceFromFile($attr->nodeValue, $info);
        });
    }
}