<?php

declare(strict_types=1);

namespace Tests;

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Exception;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

class TestCase extends PHPUnit_TestCase
{
	/**
	 * @return App
	 * @throws Exception
	 */
	protected function getAppInstance(): App
	{
		$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
		$dotenv->load();

		// Instantiate PHP-DI ContainerBuilder
		$containerBuilder = new ContainerBuilder();

		// Container intentionally not compiled for tests.

		// Set up dependencies
		$dependencies = require __DIR__ . '/../config/dependencies.php';
		$dependencies($containerBuilder);

		// Set up repositories
		$repositories = require __DIR__ . '/../config/repositories.php';
		$repositories($containerBuilder);

		// Build PHP-DI Container instance
		$container = $containerBuilder->build();

		// Instantiate the app
		AppFactory::setContainer($container);
		$app = AppFactory::create();

		// Register routes
		$routes = require __DIR__ . '/../config/routes.php';
		$routes($app);

		return $app;
	}

	/**
	 * @param string $method
	 * @param string $path
	 * @param array  $headers
	 * @param array  $cookies
	 * @param array  $serverParams
	 * @return Request
	 */
	protected function createRequest(
		string $method,
		string $path,
		array $headers = ['HTTP_ACCEPT' => 'application/json'],
		array $cookies = [],
		array $serverParams = []
	): Request {
		$uri    = new Uri('', '', 80, $path);
		$handle = fopen('php://temp', 'w+');
		$stream = (new StreamFactory())->createStreamFromResource($handle);
		$h      = new Headers();

		foreach ($headers as $name => $value) {
			$h->addHeader($name, $value);
		}

		return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
	}

	protected function createAppRequest(
		string $method,
		string $path,
		array $body = [],
		array $headers = ['HTTP_ACCEPT' => 'application/json'],
		array $cookies = [],
		array $serverParams = []
	) {
		$app     = $this->getAppInstance();
		$request = $this->createRequest($method, $path, $headers, $cookies, $serverParams)->withParsedBody($body);

		return $app->handle($request);
	}

	protected function get(string $path)
	{
		return $this->createAppRequest('GET', $path);
	}

	protected function post(string $path, array $body = [])
	{
		return $this->createAppRequest('POST', $path, $body);
	}

	protected function delete(string $path, array $body = [])
	{
		return $this->createAppRequest('DELETE', $path, $body);
	}
}
