<?php

declare(strict_types=1);

namespace Library\Middleware;

use Psr\Http\Server\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
	public function process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
	{
		$response = $handler->handle($request);
		$origin   = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

		return $response
			->withHeader('Access-Control-Allow-Credentials', 'true')
			->withHeader('Access-Control-Allow-Origin', $origin)
			->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
			->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
			->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
			->withAddedHeader('Cache-Control', 'post-check=0, pre-check=0')
			->withHeader('Pragma', 'no-cache');
	}
}
