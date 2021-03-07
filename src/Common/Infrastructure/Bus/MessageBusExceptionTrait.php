<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

trait MessageBusExceptionTrait
{
    /**
     * @throws Throwable
     */
    public function throwException(HandlerFailedException $exception): void
    {
        while ($exception instanceof HandlerFailedException) {
            /** @var Throwable $exception */
            $exception = $exception->getPrevious();
        }

        if ($exception instanceof \TypeError) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        throw $exception;
    }
}
