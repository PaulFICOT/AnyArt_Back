<?php

declare(strict_types=1);

use Tests\TestCase;

class HelloWorldTest extends TestCase
{
	public function testItWorks()
	{
		//setup

		//run
		$response = $this->get('/');

		//assert
		$this->assertEquals('Hello World!', (string) $response->getBody());
	}
}
