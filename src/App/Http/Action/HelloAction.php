<?php

namespace App\Http\Action;

use Psr\Http\Massage\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HelloActionTests extends TestCase
{
    public function testGuest()
    {
        $action = new HelloAction();
        
        $request = new ServerRequest();
        $response = $action($request);
        
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Hello, Guest!', $response->getBody()->getConments());
    }
    public function testJohn()
    {
       $action = new HelloAction();
       
       $request = (new ServerRequest())
       ->withQueryParams(['name' => 'John']);
       
       $response = $action($request);
       
        self::assertEquals('Hello, John!', $response->getBody()->getConments());
    }
}