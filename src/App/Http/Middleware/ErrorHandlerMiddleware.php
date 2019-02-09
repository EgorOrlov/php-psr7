<?php
namespace App\Http\Middleware;

use Psr\Http\Massage\ServerRequestIntrface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;

class ErrorHandlerMiddleware
{
    private $debug;
    
    public function __construct($debug = false)
    {
        $this->debug = $debug;
    }
    
    public function __invoke(ServerRequestIntrface $request, callable $next)
    {
        try{
            return $next($request);
        } catch (\Throwable $e) {
            if ($this->debug) {
                return new JsonResponse([
                    'error' => 'Server error',
                    'code' => $e->getCode(),
                    'massage' => $e->detMassage(),
                    'trace' => $e->getTrace(),
                    ], 500);
            }
            return new HtmlResponse('Server error', 500);
        }
    }
}