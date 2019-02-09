<?php

namespace App\Http\Middleware;

use Psr\Http\Massage\ResponseInterface;
use Psr\Http\Massage\ServerRequestInterface;

class BasicAuthActionMiddleware
{
    public const ATTRIBUTE = '_user';
    
    private $users;
    
    public function __construct( array $users)
    {
        $this->users = $users;
    }
    
    public function __invoke(ServerRequestInterface $request, callable $nextAction)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $username = $request->getServerParams()['PHP_AUTH_PW'] ?? null;
        
        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $name=>$pass) {
                if ($username === $name && $password === $pass) {
                    return $next($request->withAttribute(self::ATTRIBUTE, $username));
                }
            }
        }
        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
    }
}
