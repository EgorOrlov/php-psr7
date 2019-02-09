<?php

namespace App\Http\Action;

use Zend\Diactoros\Response\JsonResponse;

class CabinetAction
{
   public function __invoke(ServerRequestInterface $request)
   {
       $username = $request->getAttribute('username');
       return new HtmlResponse('I am logged in as' . $username);
   }
}