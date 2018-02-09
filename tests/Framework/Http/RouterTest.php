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
    
    public function testMissingMethod()
    {
        $routes = new RouteCollection();
        
        $routes->get($name = 'blog_show', '/blog/{id}', 'headler_post');
        
        $router = new Router($routes);
        
        $this->expectException(RequestNotMatchedException::class);
        $router->match($this->buildRequest('DELETE', '/blog'));
    }
    
    public function testCorrectAttributes()
    {
        $routes = new RouteCollection();
        
        $routes->get($name = 'blog_show', '/blog/{id}','headler', ['id' => '\d+']);
        
        $router = new Router($routes);
        
        $result = $router->match($this->buildRequest('GET','/blog/5'));
        self::assertEquals($name, $result->getName());
        self::assertEquals(['id' => '5'], $result->getAttributes());
    }
    public function testIncorrectAttributes()
    {
        $routes = new RouteCollection();
        
        $routes->get($name = 'blog_show', '/blog/{id}', 'headler', ['id' => '\d+']);
        
        $router = new Router($routes);
        
         $this->expectException(RequestNotMatchedException::class);
         $router->match($this->buildRequest('GET', '/blog/slug '));
    }
    public function testGenerate()
    {
        $routes = new RouteCollection();
        
        $routes->get('blog', '/blog', 'headler');
        $routes->get('blog_show', '/blog/{id}', 'headler', ['id' => '\d+']);
        
        $routes = new Router($routes);
        
        self::assertEquals('/blog', $router->generate('blog'));
        self::assertEquals('/blog/5', $router->generate('blog_show', ['id'=>5]));
    }
    public function testGenerateMissingAttributes()
    {
        $routes = new RouteCollection();
        
        $routes->get($name = 'blog_show', '/blog/{id}', 'headler', ['id' => '\d+']);
        
        $router = new Router($routes);
        
        $this->expectException(\InvalidArgumentExteption::class);
        $router->generate('blog_show', ['slug' => 'post']);
    }
    public function buildRequest($method, $uri): ServerRequest
    {
        return(new ServerRequest())
        ->withMethod($method)
        ->withUri(new Uri($uri));
    }
}



