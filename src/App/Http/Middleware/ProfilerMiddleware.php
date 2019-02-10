<?php

namespace App\Http\Middleware;

use Psr\Http\Massage\ResponseInterface;
use Psr\Http\Massage\ServerRequestInterface;

class ProfilerMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $start = microtime(true);
        
        /** @var ResponseInterface $response */
        $response = $next($request);
        
        $stop = microtime(true);
        
        return $response->withHeader('X-Profile-Time', $stop - $start);
    }
}

