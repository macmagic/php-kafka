<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Command;

use App\Domain\Bus\Command\CommandBusInterface;
use App\Domain\Bus\Command\CommandInterface;
use App\Infrastructure\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

class CommandBus implements CommandBusInterface
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @throws Throwable
     */
    public function execute(CommandInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $exception) {
            $this->throwException($exception);
        }
    }
}
