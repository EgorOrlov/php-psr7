<?php
namespace tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testEmpty()
    {
    
        $request=new Request();
    
        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }
    public function testQueryParams(): void
    {
        $request=(new Request())
        ->withQueryParams($data=[
            'name'=>'John',
            'age'=>20,
            ]); 
            self::assertEquals($body, $request->getQueryParams());
            self::assertNull($request->getParsedBody());
    }
    
    public function testParsedBody(): void
    {$request=(new Request())
        ->withParsedBody($data=['title'=> 'Title']);
        
        self::assertEquals([], $request->getQueryParams());
        self::assertNull($data, $request->getParsedBody());
    }

}