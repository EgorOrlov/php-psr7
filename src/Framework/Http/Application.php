<?php
namespace Framework\Http;

class Application extends Pipeline
{
    private $resolver;
    private $defoult;
    
    public function __construct(MiddlewareResolver $resolver)
    {
        parrent ::__construct();
        $this->resolver = $resolver;
        $this->defoult = $defoult;
    }
    
    public function pipe ($middleware): void
    {
        parent::pipe($this->resolver->$resolv($middleware));
    }
    
    public function run (ServerRequestInterface $request)
    {
        return $this ($request, $this->$defoult);
    }
}