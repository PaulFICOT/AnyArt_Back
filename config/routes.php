<?php

declare(strict_types=1);

use Library\Middleware\CorsMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use App\UsersDAO;
use App\CountriesDAO;
use App\PostsDAO;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
	$app->addMiddleware(new CorsMiddleware);

	$app->options('/{routes:.*}', function (Request $request, Response $response) {
		// CORS Pre-Flight OPTIONS Request Handler
		return $response;
	});

	$app->group('/api', function (RouteCollectorProxy $group) {
		$group->group('/posts', function (RouteCollectorProxy $group) {
			/**
			 * Get all post thumbnails
			 */
			$group->get('/thumbnails', function (Request $request, Response $response, $args) {
				$postsDAO = new PostsDAO();

				$response->getBody()->write(json_encode($postsDAO->getThumbnails()));
				$response = $response->withStatus(200);
				return $response->withHeader('Content-Type', 'application/json');
			});
		});

		$group->group('/users', function (RouteCollectorProxy $group) {
			/**
			 * Get all users
			 */
			$group->get('', function (Request $request, Response $response) {
				$usersDAO = new UsersDAO();

				$response->getBody()->write(json_encode($usersDAO->getUsers()));
				$response = $response->withStatus(200);
				return $response->withHeader('Content-Type', 'application/json');
			});

			/**
			 * Create a new user account
			 */
			$group->post('', function (Request $request, Response $response, $args) {
				$usersDAO = new UsersDAO();
				$usersDAO->createUser(json_decode(strval($request->getBody()), true));

				$response->getBody()->write("The user was created successfully.");
				$response = $response->withStatus(200);
				return $response->withHeader('Content-Type', 'text/plain');
			});

			/**
			 * Get a user with the id of this user
			 */
			$group->get('/{id}', function (Request $request, Response $response, $args) {
				$usersDAO = new UsersDAO();
				$user = $usersDAO->getUsersById($args['id']);

				if (empty($user)) {
					$response->getBody()->write("The user with this id (" . $args["id"] . ") is not found.");
					$response = $response->withStatus(500);
					$response = $response->withHeader('Content-Type', 'text/plain');
				} else {
					$response->getBody()->write(json_encode($user));
					$response = $response->withStatus(200);
					$response = $response->withHeader('Content-Type', 'application/json');
				}

				return $response;
			});
		});

		$group->group('/countries', function (RouteCollectorProxy $group) {
			/**
			 * Get all countries
			 */
			$group->get('', function (Request $request, Response $response) {
				$countriesDAO = new CountriesDAO();

				$response->getBody()->write(json_encode($countriesDAO->getCountries()));
				$response = $response->withStatus(200);
				return $response->withHeader('Content-Type', 'application/json');
			});

			/**
			 * Get a country with the id of this country
			 */
			$group->get('/{id}', function (Request $request, Response $response, $args) {
				$countriesDAO = new CountriesDAO();
				$country = $countriesDAO->getCountriesById($args['id']);

				if (empty($country)) {
					$response->getBody()->write("The country with this id (" . $args["id"] . ") is not found.");
					$response = $response->withStatus(500);
					$response = $response->withHeader('Content-Type', 'text/plain');
				} else {
					$response->getBody()->write(json_encode($country));
					$response = $response->withStatus(200);
					$response = $response->withHeader('Content-Type', 'application/json');
				}

				return $response;
			});

		});

		/**
		 * Sign in with a user account
		 */
		$group->post('/signin', function (Request $request, Response $response, $args) {
			$usersDAO = new UsersDAO();
			$params = json_decode(strval($request->getBody()), true);
			$user = $usersDAO->getUsersByEmail($params['email']);

			if (empty($user)) {
				$response->getBody()->write("Invalid email or password");
				$response = $response->withStatus(500);
				return $response->withHeader('Content-Type', 'text/plain');
			}

			if (password_verify($params['password'], $user['password'])) {
				$response->getBody()->write("OK!");
				$response = $response->withStatus(200);
				return $response->withHeader('Content-Type', 'text/plain');
			}

			$response->getBody()->write("Invalid email or password");
			$response = $response->withStatus(500);
			return $response->withHeader('Content-Type', 'text/plain');
		});

		/**
		 * Catch-all route to serve a 404 Not Found page if none of the routes match
		 * NOTE: make sure this route is defined last
		 */
		$group->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
			throw new HttpNotFoundException($request);
		});
	});
};
