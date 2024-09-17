<?php

namespace App\EventListener\Exception;

use App\Exception\UseCase\AbstractUseCaseException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception', method: 'onKernelException')]
class UseCaseExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AbstractUseCaseException) {
            $response = new JsonResponse([
                'error' => $exception->getMessage(),
                'details' => '',
            ], 400);

            $event->setResponse($response);
        }
    }
}