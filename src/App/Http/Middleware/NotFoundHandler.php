<?php

namespace App\Http\Middleware;

use Psr\Http\Massage\ServerRequestInterface;

class NotFoundHandler
{
    public function __invoke(ServerRequestInterface $request)
    {
    return new HtmlResponse('Undefined page', 404);    
    }
}