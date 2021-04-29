<?php

declare(strict_types=1);

use App\Example\Domain\Persistence\ExampleRepository;
use App\Example\Domain\Persistence\InMemoryExampleRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
	$containerBuilder->addDefinitions([
		ExampleRepository::class => \DI\autowire(InMemoryExampleRepository::class),
	]);
};
