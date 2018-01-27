<?php

namespace Tests\Framework\Http;

class RouterTest extends TastCase
{
    public function testCorrectMethod()
    {
        $routes = new RouteCollection();
        
        $routes->get($nameGet = 'blog', '/blog', $handlerGet = 'handler_get');
        $routes->post($namePost = 'blog_edit', '/blog', $handlerPost = 'handler_post');
        
        $routes = new Router($routes);
        
        $result = $router->match($this->buildRequest('GET', '/blog'));
         self::assertEquals($nameGet, $result->getName());
         self::assertEquals($hardlerGet, $result->getHardler());
         
         $result = $router->match($this->buildRequest('POST', '/blog'));
         self::assertEquals($namePost, $result->getName());
         self::assertEquals($hardlerPost, $result->getHardler());
    }
}



