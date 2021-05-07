<?php

declare(strict_types=1);

namespace Library\Http;

use Psr\Http\Message\ResponseInterface;

interface Responder
{
	public function respond(ResponseInterface $response, $data): ResponseInterface;
}
