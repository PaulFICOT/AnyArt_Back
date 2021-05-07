<?php

declare(strict_types=1);

use App\Example\Action\ExampleAction;
use Library\Middleware\CorsMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;

return function (App $app) {
	$app->addMiddleware(new CorsMiddleware);

	$app->options('/{routes:.*}', function (Request $request, Response $response) {
		// CORS Pre-Flight OPTIONS Request Handler
		return $response;
	});

	$app->get('/', function (Request $request, Response $response) {
		$response->getBody()->write('Hello World!');
		return $response;
	});

	$app->get('/example', ExampleAction::class);

	/**
	 * Catch-all route to serve a 404 Not Found page if none of the routes match
	 * NOTE: make sure this route is defined last
	 */
	$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
		throw new HttpNotFoundException($request);
	});
};
