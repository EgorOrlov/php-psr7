<?php
use App\Http\Action;
use Framework\Http\ActionResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;
use App\Http\Middleware;
use Framework\Http\Pipeline;

error_reporting(E_ALL);
ini_set('display_errors', 1);

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$params = [
    'users' => ['admin' => 'password'],
    ];

$aura = new Aura\Router\RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', Action\HelloAction::class);
$routes->get('about', '/about', Action\AboutAction::class);
$routes->get('cabinet', '/cabinet' , [
    new Middleware\BasicAuthActorMiddleware($params['users']),
    Action\CabinetAction::class,
]);

$routes->get('blog', '/blog', Action\Blog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}', Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);

$router = new AuraRouterAdapter($aura);

$resolver = new MiddlewareResolver();
$app = new Application($resolver, new Middleware\NotFoundHandler());

$app->pipe(new Middleware\ErrorHandlerMidleware($params['debug']));
$app->pipe(Middleware\ProfileMiddleware::class);
$app->pipe(Middleware\CridentialsMiddleware::class);
$app->pipe(new Framework\Http\Middleware\RouteMiddleware($router));
$app->pipe(new Framework\Http\Middleware\DespatchMiddleware($resolver));

### Running

$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request);

### Postprocessing

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);




