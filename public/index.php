<?php
use App\Http\Action;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouterCollection;
use Framework\Http\Router\Router;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;


chdir(dirname(__DIR__));
require 'vendor/autoload.php';

###initialization

$aura = new Aura\Router\RouterContainer();
$routes = new RouterCollection();

$routes->get('home', '/', Action\HelloAction::class);
$routes->get('about', '/about', Action\AboutAction::class);
$routes->get('blog', '/blog',  Action\Bloog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}',Action\Blog\ShowAction::class, ['id' =>'\d+']);

$router = new AuraRouterAdapter($aura);
$resolver = new \Framework\Http\ActionResolver();

###Runing

$request = ServerRequestFactory::fromGlobals();
try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value){
        $request = $request->withAttribute($attribute, $value);
    }
    $handler = $result->getHandler();
    $action = $resolver->resolver($handler);
    $response = $action($request);
} catch (RequestNotMatchedException $e){
    $response = new JsonResponse(['error' => 'Underfined page'], 404);
}
###Postprocessing

$response = $response->withHeader('X-Developer', ElisDN);
    
    ### Sending
    
  $emitter = new SapiEmitter();
  $emitter->emit($response);

?>