<?php

declare(strict_types=1);

namespace Tests\Unit\Example\Domain\Entity;

use App\Example\Domain\Entity\ExampleEntity;
use Tests\TestCase;

class ExampleEntityTest extends TestCase
{
	public function testItWorks()
	{
		//setup
		$example = new ExampleEntity('Test');

		//run
		$result = $example->getName();

		//assert
		$this->assertEquals('Test', $result);
	}
}
