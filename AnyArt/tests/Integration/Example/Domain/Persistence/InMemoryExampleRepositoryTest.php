<?php

declare(strict_types=1);

namespace Tests\Integration\Example\Domain\Persistence;

use App\Example\Domain\Persistence\InMemoryExampleRepository;
use Tests\TestCase;

class InMemoryExampleRepositoryTest extends TestCase
{
	public function testItWorks()
	{
		//setup
		$repository = new InMemoryExampleRepository;

		//run
		$result = $repository->get();

		//assert
		$this->assertEquals('Test', $result->getName());
	}
}
