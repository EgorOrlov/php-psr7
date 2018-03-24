<?php

namespace Framework\Http\Router;

use Aura\Router\Exteption\RouteNoteFound;
use Aura\Router\RouterContainer;
use Framework\Http\Router\RequestNotMatchedExteption;
use Framework\Http\Router\Exteption\RequestNotFoundExteption;
use Psr\Http\Message\ServerRequestInterface;

class AuraRouterAdapter implements Router
{
    private $aura;
    
    public function __construct(RouterContainer $aura)
    {
        $this->aura = $aura;
    }
    public function match(ServerRequestInterface $request): Result
    {
        $matcher = $this->aura->getMatcher();
        if ($route = $matcher->match($request)) {
            return new Result($route->name, $route->handler, $route->attributes);
        }
        throw new RequestNotMatchedExteption($request);
    }

    public function generate($name, array $params): string
    {
        $generator = $this->aura->getGenerator($name, $params);
        try{
            return $generator->generate($name, $params);
        }catch (RouteNoteFound $e) {
            throw new RequestNotFoundExteption($name, $params, $e);
        }
    }
}
