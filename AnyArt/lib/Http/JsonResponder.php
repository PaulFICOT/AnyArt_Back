<?php

declare(strict_types=1);

namespace Library\Http;

use Psr\Http\Message\ResponseInterface;

class JsonResponder implements Responder
{
	public function respond(ResponseInterface $response, $data): ResponseInterface
	{
		$response->getBody()->write(json_encode($data));

		return $response;
	}
}
