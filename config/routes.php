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

			// Get all post thumbnails
			$group->get('/thumbnails/{params}', function (Request $request, Response $response, $args) {
				$postsDAO = new PostsDAO();

				switch ($args['params']) {
					case 'unlogged':
						return resolveResponse($response, 200, $postsDAO->getThumbnailsUnlogged());
						break;
					case 'newpost':
						return resolveResponse($response, 200, $postsDAO->getThumbnailsNewPosts());
						break;
					case 'hottest':
						return resolveResponse($response, 200, $postsDAO->getThumbnailsHottests());
						break;
					case 'raising':
						return resolveResponse($response, 200, $postsDAO->getThumbnailsRaising());
						break;
					default:
						return resolveResponse($response, 200, $postsDAO->getThumbnailsUnlogged());
						break;
				}
			});

			$group->group('/{id}', function (RouteCollectorProxy $group) {
				$group->get('', function (Request $request, Response $response, $args) {
					$query_params = $request->getQueryParams();
					$postsDAO = new PostsDAO();
					$post = $postsDAO->getPostAndUserByPostId([
						':post_id' => $args['id'],
						':user_id' => $query_params['user_id']
					]);
					if (empty($post)) {
						return resolveResponse($response, 500, ["message" => "The post with this id (" . $args["id"] . ") is not found."]);
					}
					$postsDAO->view($args['id']);
					return resolveResponse($response, 200, $post);
				});

				$group->get('/categories', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();
					$categories = $postsDAO->getCategoriesByPostId($args['id']);

					if (empty($categories)) {
						return resolveResponse($response, 500, ["message" => "The post with this id (" . $args["id"] . ") is not found."]);
					}

					return resolveResponse($response, 200, $categories);
				});

				$group->get('/tags', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();
					$tags = $postsDAO->getTagsByPostId($args['id']);

					return resolveResponse($response, 200, $tags);
				});

				$group->get('/pictures', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();
					$pictures = $postsDAO->getPicturesByPostId($args['id']);

					if (empty($pictures)) {
						return resolveResponse($response, 500, ["message" => "The post with this id (" . $args["id"] . ") is not found."]);
					}

					return resolveResponse($response, 200, $pictures);
				});

				$group->get('/comments', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();
					$comments = $postsDAO->getCommentByPostId($args['id']);

					return resolveResponse($response, 200, $comments);
				});

				$group->post('/comments', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();

					$body = json_decode($request->getBody()->getContents(), true);

					$postsDAO->newComment([
						':content' => $body['content'],
						':crea_date' => $body['crea_date'],
						':reply_to' => $body['reply_to'],
						':user_id' => $body['user_id'],
						':post_id' => $args['id']
					]);

					return resolveResponse($response, 200, ["message" => 'Comment successfully added']);
				});

				$group->get('/opinion', function (Request $request, Response $response, $args) {$postsDAO = new PostsDAO();
					$postsDAO = new PostsDAO();
					$opinions = $postsDAO->getOpinion($args['id']);

					return resolveResponse($response, 200, [
						'likes' => $opinions[1] ?? 0,
						'dislikes' => $opinions[0] ?? 0
					]);
				});

				$group->post('/opinion', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();
					$body = json_decode($request->getBody()->getContents(), true);

					switch ($body['action']) {
						case 'like':
							$postsDAO->setOpinion([
								':post_id' => $args['id'],
								':user_id' => $body['user_id'],
								':crea_date' => $body['crea_date'],
								':is_like' => 1
							]);
							break;
						case 'dislike':
							$postsDAO->setOpinion([
								':post_id' => $args['id'],
								':user_id' => $body['user_id'],
								':crea_date' => $body['crea_date'],
								':is_like' => 0
							]);
							break;
						case 'remove':
							$postsDAO->rmOpinion([
								':post_id' => $args['id'],
								':user_id' => $body['user_id']
							]);
							break;
						default:
							return resolveResponse($response, 400, ['message', 'Invalid action']);
					}

					return resolveResponse($response, 200, ['message', 'Opinion successfully saved']);
				});

				$group->patch('/view', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();

					$postsDAO->view($args['id']);
				});

				$group->patch('/cancel-like', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();
					$body = json_decode($request->getBody()->getContents());

					$postsDAO->rmLike([
						'post_id' => $args['id'],
						'user_id' => $body['user_id']
					]);

					return resolveResponse($response, 200, ["message" => 'Like successfully removed']);
				});

				$group->get('/discover', function (Request $request, Response $response, $args) {
					$postsDAO = new PostsDAO();
					$comments = $postsDAO->getThumbnailsDiscover($args['id']);

					return resolveResponse($response, 200, $comments);
				});
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

			/**
			 * Get all users
			 */
			$group->post('/verif', function (Request $request, Response $response) {
				$usersDAO = new UsersDAO();
				$param = json_decode(strval($request->getBody()), true);
				return resolveResponse($response, 200, ["login" => $usersDAO->verifToken($param['id'], $param['token'])]);
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
								->withClaim('uid', $user['user_id'])
								->getToken($config->signer(), $config->signingKey());

				$usersDAO->setToken($user['user_id'], $token->toString());

				$data_user = [
					'user_id' => $user['user_id'],
					'lastname' => $user['lastname'],
					'firstname' => $user['firstname'],
					'mail' => $user['mail'],
					'birth_date' => $user['birth_date'],
					'username' => $user['username'],
					'is_verified' => $user['is_verified'],
					'is_active' => $user['is_active'],
					'is_banned' => $user['is_banned'],
					'profile_desc' => $user['profile_desc'],
					'type' => $user['type'],
					'job_function' => $user['job_function'],
					'open_to_work' => $user['open_to_work'],
					'country_id' => $user['country_id'],
				];

				return resolveResponse($response, 200, ["token" => $token->toString(), "user" => $data_user]);
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
