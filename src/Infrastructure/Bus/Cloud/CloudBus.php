<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Cloud;

use App\Domain\Bus\Cloud\CloudBusInterface;
use App\Domain\Bus\Cloud\CloudMessageInterface;
use App\Infrastructure\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

class CloudBus implements CloudBusInterface
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
    public function send(CloudMessageInterface $message): void
    {
        try {
            $this->messageBus->dispatch($message);
        } catch (HandlerFailedException $exception) {
            $this->throwException($exception);
        }
    }
}
