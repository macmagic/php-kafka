<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\EventSubscriber;

use App\Common\Application\Exception\AppException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => ['onKernelException', 0]];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AppException) {
            $response = $this->makeRequestFromException($exception);
            $event->setResponse($response);
        }
    }

    private function makeRequestFromException(AppException $exception): Response
    {
        $content = [
            'error' => [
                'app_code' => $exception->getAppCode(),
                'message' => $exception->getMessage(),
            ],
        ];

        $response = new JsonResponse();

        $response->setStatusCode($exception->getExceptionCode());
        $response->setContent(json_encode($content));

        return $response;
    }
}
