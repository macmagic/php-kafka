<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Query;

use App\Common\Domain\Bus\Query\QueryBusInterface;
use App\Common\Domain\Bus\Query\QueryInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;
use App\Common\Infrastructure\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

class QueryBus implements QueryBusInterface
{
    use MessageBusExceptionTrait;

    private MessageBus $messageBus;

    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @throws Throwable
     */
    public function ask(QueryInterface $query): ?ResponseInterface
    {
        try {
            $envelope = $this->messageBus->dispatch($query);

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $exception) {
            $this->throwException($exception);
        }

        return null;
    }
}
