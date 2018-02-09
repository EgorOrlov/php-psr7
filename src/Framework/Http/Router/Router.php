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
            
            
            if ($route->methods && !\in_array($request->getMethod(), $route->methods, true)){
               
                continue; 
            }
            $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use ($route) {
                $argument = $matches[1];
                $replace = $route->tokens[$argument] ?? '[^}]+';
                return '(?P<' . $argument . '>' . $replace . ')';
            },$route->pattern);
            
            $path = $request->getUri()->getPath();
            if (preg_match('~^'. $pattern. '$~i'. $path, $matches)) {
                
                return new Result(
                    $route->name,
                    $route->handler,
                    array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY));
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