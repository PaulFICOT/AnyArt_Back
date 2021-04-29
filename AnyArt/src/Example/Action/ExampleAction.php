<?php

declare(strict_types=1);

namespace App\Example\Action;

use App\Example\Domain\Persistence\ExampleRepository;
use Library\Http\JsonResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExampleAction
{
	private ExampleRepository $repository;
	private JsonResponder $responder;

	public function __construct(ExampleRepository $repository, JsonResponder $responder)
	{
		$this->repository = $repository;
		$this->responder  = $responder;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		return $this->responder->respond($response, $this->repository->get());
	}
}
