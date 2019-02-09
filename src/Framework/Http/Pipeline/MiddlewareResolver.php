<?php

namespace Framework\Http\Pipeline;

class MiddlewareResolver
{ 
    public function resolve($handler) : callable
    {
        if (\is_array($handler)){
            return $this->criatePipe($handler);
        }
        
        if (\is_string($handler)) {
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $object = new $handler();  
                return $object($request, $next);
            };
        }
        return $handler;
    }
    
    private function criatePipe(array $handlers): Pipeline
    { 
        $pipeline = new Pipeline();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler));
        }
        return $pipeline;
    }
}