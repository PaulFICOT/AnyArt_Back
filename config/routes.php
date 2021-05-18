<?php

declare(strict_types=1);

use App\CountriesDAO;
use App\PostsDAO;
use App\UsersDAO;
use Library\Middleware\CorsMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

function resolveResponse($response, $statusCode, $content) {
	$response = $response->withStatus($statusCode);
	$response = $response->withHeader('Content-Type', 'application/json');
	$response->getBody()->write(json_encode($content));

	return $response;
}

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
				return resolveResponse($response, 200, $postsDAO->getThumbnails());
			});
		});

		$group->group('/users', function (RouteCollectorProxy $group) {
			/**
			 * Get all users
			 */
			$group->get('', function (Request $request, Response $response) {
				$usersDAO = new UsersDAO();
				return resolveResponse($response, 200, $usersDAO->getUsers());
			});

			/**
			 * Create a new user account
			 */
			$group->post('', function (Request $request, Response $response, $args) {
				$usersDAO = new UsersDAO();
				try {
					$usersDAO->createUser(json_decode(strval($request->getBody()), true));
				} catch (PDOException $e) {
					if ($e->errorInfo[1] == 1062) {
						return resolveResponse($response, 400, ["message" => "This email already exists."]);
					}
				}
				return resolveResponse($response, 200, ["message" => "The user was created successfully."]);
			});

			/**
			 * Get a user with the id of this user
			 */
			$group->get('/{id}', function (Request $request, Response $response, $args) {
				$usersDAO = new UsersDAO();
				$user = $usersDAO->getUsersById($args['id']);

				if (empty($user)) {
					return resolveResponse($response, 500, ["message" => "The user with this id (" . $args["id"] . ") is not found."]);
				}
				return resolveResponse($response, 200, $user);
			});
		});

		$group->group('/countries', function (RouteCollectorProxy $group) {
			/**
			 * Get all countries
			 */
			$group->get('', function (Request $request, Response $response) {
				$countriesDAO = new CountriesDAO();
				return resolveResponse($response, 200, $countriesDAO->getCountries());
			});

			/**
			 * Get a country with the id of this country
			 */
			$group->get('/{id}', function (Request $request, Response $response, $args) {
				$countriesDAO = new CountriesDAO();
				$country = $countriesDAO->getCountriesById($args['id']);

				if (empty($country)) {
					return resolveResponse($response, 500, ["message" => "The country with this id (" . $args["id"] . ") is not found."]);
				}
					return resolveResponse($response, 200, $country);
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
				return resolveResponse($response, 400, ["message" => "Invalid email or password"]);
			}

			if (password_verify($params['password'], $user['password'])) {
				$config = Configuration::forSymmetricSigner(
					new Sha256(),
					InMemory::plainText('supersecret')
				);

				$now   = new DateTimeImmutable();
				$token = $config->builder()
								->identifiedBy('4f1g23a12aa')
								->issuedAt($now)
								->canOnlyBeUsedAfter($now->modify('+1 minute'))
								->expiresAt($now->modify('+24 hour'))
								->withClaim('user', $user)
								->getToken($config->signer(), $config->signingKey());

				return resolveResponse($response, 200, ["token" => $token->toString()]);
			}

			return resolveResponse($response, 400, ["message" => "Invalid email or password"]);
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
