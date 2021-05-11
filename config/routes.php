<?php

declare(strict_types=1);

use Library\Middleware\CorsMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use App\UsersDAO;

return function (App $app) {
	$app->addMiddleware(new CorsMiddleware);

	$app->options('/{routes:.*}', function (Request $request, Response $response) {
		// CORS Pre-Flight OPTIONS Request Handler
		return $response;
	});

	/**
	 * Get all users
	 */
	$app->get('/api/users', function (Request $request, Response $response) {
		$usersDAO = new UsersDAO();

		$response->getBody()->write(json_encode($usersDAO->getUsers()));
        $response = $response->withStatus(200);
        return $response->withHeader('Content-Type', 'application/json');
	});

	/**
	 * Get a user with the id of this user
	 */
	$app->get('/api/users/{id}', function (Request $request, Response $response, $args) {
		$usersDAO = new UsersDAO();
		$user = $usersDAO->getUsersById($args['id']);

		if (empty($user)) {
			$response->getBody()->write("The user with this id (". $args["id"] . ") is not found.");
			$response = $response->withStatus(500);
            $response = $response->withHeader('Content-Type', 'text/plain');
		} else {
			$response->getBody()->write(json_encode($user));
			$response = $response->withStatus(200);
            $response = $response->withHeader('Content-Type', 'application/json');
		}

		return $response;
	});

	/**
	 * Create a new user account
	 */
	$app->post('/api/users', function (Request $request, Response $response, $args) {
		$usersDAO = new UsersDAO();
		$usersDAO->createUser(json_decode(strval($request->getBody()), true));

		$response->getBody()->write("The user was created successfully.");
		$response = $response->withStatus(200);
        return $response->withHeader('Content-Type', 'text/plain');
	});

	/**
	 * Catch-all route to serve a 404 Not Found page if none of the routes match
	 * NOTE: make sure this route is defined last
	 */
	$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
		throw new HttpNotFoundException($request);
	});
};
