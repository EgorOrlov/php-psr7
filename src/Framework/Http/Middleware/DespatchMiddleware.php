<?php

namespace Framework\Http\Middleware;

class DespatchMiddleware
{
      private $resolver;
      
      public function __construct(MiddlewareResolver $resolver)
    {
        $this->resolver = $resolver;
    }
    
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        if (!$result = $request->getAttributes(Result::class)) {
            return $next($request);
        }
        $middleware = $this->resolver->$resolver($result->getHandler());
        return $middleware($request, $next);
    }
}