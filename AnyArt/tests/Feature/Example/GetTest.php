<?php

declare(strict_types=1);

namespace Tests\Feature\Example;

use Tests\TestCase;

class GetTest extends TestCase
{
	public function testItWorks()
	{
		//setup

		//run
		$response = $this->get('/example');
		$response = json_decode((string) $response->getBody(), true);

		//assert
		$this->assertEquals('Test', $response['name']);
	}
}
