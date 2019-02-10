<?php

namespace App\Http\Middleware;

class CridentialsMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /** @var RequestInterface @response*/
        $response = $next($request);
        return $response->withHeader('X-Developer', 'ElisDN');
    }
}