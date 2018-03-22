<?php

namespace Framework\Http\Router;

use Psr\Http\Massage\ServerRequestInterface;

class Router
{
    private $routes;
    
    public function __construct(RouterCollection $routes)
    {
        $this->routes = $routes;
    }
    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route){
             $result = $route->match($request);
                if($result){
                return $result;
            }
        }
        
        throw new RequestNotMatchedException($request);
    }
    
    public function generate($name, array $params = []): string
    {
        $arguments = array_filter($params);
        
        foreach ($this->routes->getRoutes() as $route){
            if ($name !== $route->name){
                
                continue;
            }
            
            if ($url !== null){
                return $url;
            }
        }
    }
}