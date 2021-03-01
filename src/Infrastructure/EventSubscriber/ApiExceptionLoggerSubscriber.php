<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSubscriber;

use App\Application\Exception\AppException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

class ApiExceptionLoggerSubscriber implements EventSubscriberInterface
{
    private const CRITICAL_EXCEPTION_CODE = 500;

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => ['onKernelException', 1]];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AppException) {
            $this->logAppException($exception);
        } else {
            $this->logGeneralException($exception);
        }
    }

    private function logGeneralException(Throwable $exception): void
    {
        $message = sprintf(
            'Uncaught exception %s: "%s" at %s line %s',
            \get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );

        $this->logger->log(LogLevel::CRITICAL, $message, ['exception' => $exception]);
    }

    private function logAppException(AppException $exception): void
    {
        $logLevel = $this->getLogLevel($exception);

        $message = sprintf(
            'AppException with exception code %d and app code %s, the error is: %s',
            $exception->getExceptionCode(),
            $exception->getAppCode(),
            $exception->getMessage()
        );

        $this->logger->log($logLevel, $message, ['exception' => $exception]);
    }

    private function getLogLevel(AppException $exception): string
    {
        return self::CRITICAL_EXCEPTION_CODE === $exception->getExceptionCode() ? LogLevel::CRITICAL : LogLevel::ERROR;
    }
}
