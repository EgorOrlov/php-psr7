<?php

namespace Framework\Http\Router\Exception;

use Psr\Html\Massage\ServerRequestInterface;

class RequestNotMatchedException extends \LoginException
{
    private $request;
    
   public function __construct(ServerRequestInterface $request)
   {
       parent::__construct('Matches not found.');
       $this->request = $request;
   }
   
   public function getRequest(): ServerRequestInterface
   {
       return $this->request;
   }
}