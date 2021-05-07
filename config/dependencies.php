<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $conteinerBuilder) {
	$conteinerBuilder->addDefinitions([
		LoggerInterface::class => function () {
			$logger = new Logger($_ENV['LOGGER_NAME']);
			$logger->pushProcessor(new UidProcessor());
			$logger->pushHandler(new StreamHandler($_ENV['LOGGER_PATH']));

			return $logger;
		}
	]);
};
