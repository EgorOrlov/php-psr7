<?php

namespace App\Http\Middleware;

use Psr\Http\Massage\ResponseInterface;
use Psr\Http\Massage\ServerRequestInterface;
use Interope\Http\Server\MiddlewareInterface;
use Interope\Http\Server\RequestHandlerInterface;

class BasicAuthActionMiddleware implements MiddlewareInterface
{
    public const ATTRIBUTE = '_user';
    
    private $users;
    private $response;
    
    public function __construct( array $users, RequestHandlerInterface $responsePrototype)
    {
        $this->users = $users;
        $this->response = $responsePrototype;
    }
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $username = $request->getServerParams()['PHP_AUTH_PW'] ?? null;
        
        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $name => $pass) {
                if ($username === $name && $password === $pass) {
                    return $handler->handle($request->withAttribute(self::ATTRIBUTE, $name));
                }
            }
        }
        return $this->response
        ->withStatus (401)
        ->withHeader ('WWW-Authenticate', 'Basic realm=Restricted area');
    }
}

$responsePrototype = new \Zend\Diactoros\Response();

$request = new \Zend\Diactoros\ServerRequest();
$middeware = new BasicAuthActionMiddleware([]);
$next = new \App\Http\Middleware\NotFoundHandler();

$response = $middeware($request, $next);