<?php

namespace App\Example\Api;

use Neoan\NeoanApp;
use Neoan\Routing\Attributes\Get;
use Neoan\Routing\Interfaces\Routable;
use ReflectionException;

#[Get('/api')]
class Docs implements Routable
{
    public function __invoke(NeoanApp $app): array
    {
        $controllers = glob($app->appPath . '/*/Routes/*.php');
        $topics = [];
        foreach ($controllers as $controller) {
            $controller = 'App\\' . substr($controller, strlen($app->appPath) + 1, -4);
            $controller = str_replace('/', '\\', $controller);
            preg_match('/App\\\\([^\\\\]+)/',$controller, $topic);
            if(!isset($topics[$topic[1]])){
                $topics[$topic[1]] = [];
            }
            // move up
            $reflection = new \ReflectionClass($controller);
            foreach($reflection->getAttributes() as $attribute){
                $route = $attribute->getArguments()[0];
                preg_match_all('/:([a-z0-9]+)(\*)*/i', $route, $paramMatches, PREG_SET_ORDER);
                $params = [];
                foreach ($paramMatches as $match) {
                    if(isset($match[1])){
                        $params[] = [
                            'property' =>$match[1],
                            'type' => 'parameter',
                            'required' => !isset($match[2]),
                        ];
                    }
                }
                $invoke = $reflection->getMethod('__invoke');

                $method = strtoupper(str_replace('Neoan\\Routing\\Attributes\\', '',$attribute->getName()));
                if($method === 'WEB'){
                    // the only one?
                    if(empty($topics[$topic[1]])){
                        unset($topics[$topic[1]]);
                    }
                    continue;
                }
                $returns = $invoke->getReturnType();
                if(method_exists($returns, 'getTypes')){
                    $returns = array_map(fn($type) => $type->getName(), $returns->getTypes());
                } else {
                    $returns = [$returns->getName()];
                }
                $topics[$topic[1]][] = [
                    'method' => $method,
                    'route' => $route,
                    'properties' => [...$params, ...$this->findProperties($invoke)],
                    'returns' => $returns,
                    'expanded' => false,
                    'try' => false
                ];
            }
            foreach($topics as $i => $topic){
                usort($topics[$i], function($a, $b){
                    return strcmp($a['method'], $b['method']);
                });
            }


        }
        return ['topics' => $topics];
    }

    /**
     * @throws ReflectionException
     */
    private function findProperties(\ReflectionMethod $invoke): array
    {
        $properties = [];
        foreach ($invoke->getParameters() as $parameter){
            if(str_contains($parameter->getType()->getName(), '\\Requests\\')){
                $requestReflection = new \ReflectionClass($parameter->getType()->getName());
                foreach($requestReflection->getProperties() as $property){
                    $properties[] = [
                        'property' => $property->getName(),
                        'type' => $property->getType()->getName(),
                        'required'  => !$property->getType()->allowsNull(),
                    ];
                }
            }

        }
        usort($properties, function($a, $b){
            return strcmp($a['property'], $b['property']);
        });
        return $properties;
    }
}