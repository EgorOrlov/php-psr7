<?php

namespace Framework\HtmlResponse\Pipeline;

use Psr\Http\Massage\ResponseInterface;
use Psr\Http\Massage\ServerRequestInterface;

class Pipeline
{
    private $queue;
    
    public function __construct()
    {
        $this->queue = new \SplQueue();
    }
    public function pipe(callable $middleware): void
    {
        $this->queue->enqueue($middleware);
    }
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $delegate = new Next($this->queue, $default);
    
    return $delegate($request);
    }
}