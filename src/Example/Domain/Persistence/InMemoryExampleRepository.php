<?php

namespace App\Example\Domain\Persistence;

use App\Example\Domain\Entity\ExampleEntity;

class InMemoryExampleRepository implements ExampleRepository
{
	public function get(): ExampleEntity
	{
		return new ExampleEntity('Test');
	}
}
