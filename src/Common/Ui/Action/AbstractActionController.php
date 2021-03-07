<?php

declare(strict_types=1);

namespace App\Common\Ui\Action;

use App\Common\Domain\Bus\Cloud\CloudBusInterface;
use App\Common\Domain\Bus\Cloud\CloudMessageInterface;
use App\Common\Domain\Bus\Command\CommandBusInterface;
use App\Common\Domain\Bus\Command\CommandInterface;
use App\Common\Domain\Bus\Query\QueryBusInterface;
use App\Common\Domain\Bus\Query\QueryInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;

abstract class AbstractActionController
{
    private CloudBusInterface $cloudBus;

    private CommandBusInterface $commandBus;

    private QueryBusInterface $queryBus;

    public function __construct(
        CloudBusInterface $cloudBus,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus
    ) {
        $this->cloudBus = $cloudBus;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function send(CloudMessageInterface $cloudMessage): void
    {
        $this->cloudBus->send($cloudMessage);
    }

    public function execute(CommandInterface $command): void
    {
        $this->commandBus->execute($command);
    }

    public function ask(QueryInterface $query): ?ResponseInterface
    {
        return $this->queryBus->ask($query);
    }
}
