<?php

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

$dependencies = require __DIR__ . '/../config/dependencies.php';
$dependencies($containerBuilder);

$repositories = require __DIR__ . '/../config/repositories.php';
$repositories($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

$app->addRoutingMiddleware();

$app->run();
