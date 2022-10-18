<?php

declare(strict_types=1);

namespace App\Core\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Throwable;
use InvalidArgumentException;

class KernelExceptionSubscriber implements EventSubscriberInterface
{
    protected bool $debug;

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();
        $response->setStatusCode($this->getStatusCode($exception));
        $response->setData([
            'message' => $exception->getMessage(),
        ]);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    private function getStatusCode(Throwable $exception): int
    {
        return match (true) {
            $exception instanceof BadRequestHttpException, $exception instanceof InvalidArgumentException => Response::HTTP_BAD_REQUEST,
            $exception instanceof NotFoundHttpException => Response::HTTP_NOT_FOUND,
            $exception instanceof AccessDeniedException => Response::HTTP_FORBIDDEN,
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
        };
    }
}
