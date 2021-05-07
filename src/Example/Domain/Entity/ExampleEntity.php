<?php

declare(strict_types=1);

namespace App\Example\Domain\Entity;

use JsonSerializable;

class ExampleEntity implements JsonSerializable
{
	private string $name;

	public function __construct(string $name = '')
	{
		$this->name = $name;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function jsonSerialize()
	{
		return [
			'name' => $this->name
		];
	}
}
