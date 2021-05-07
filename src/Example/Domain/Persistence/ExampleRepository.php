<?php

declare(strict_types=1);

namespace App\Example\Domain\Persistence;

use App\Example\Domain\Entity\ExampleEntity;

interface ExampleRepository
{
	public function get(): ExampleEntity;
}
