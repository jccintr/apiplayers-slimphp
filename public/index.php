<?php
use Symfony\Component\Dotenv\Dotenv;
use DI\Container;
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');



$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../src/definitions.php');
$container = $containerBuilder->build();
AppFactory::setContainer($container);

$app = AppFactory::create();
$app->addBodyParsingMiddleware();


require_once __DIR__ . '/../routes/api.php';


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Bem vindo a Api Players");
   
    return $response;
});


$app->run();
