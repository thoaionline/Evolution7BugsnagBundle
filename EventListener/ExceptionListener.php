<?php
namespace Evolution7\BugsnagBundle\EventListener;

use Evolution7\BugsnagBundle\Bugsnag\ClientLoader,
    Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent,
    Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * The BugsnagBundle ExceptionListener.
 *
 * Handles exceptions that occur in the code base.
 *
 */
class ExceptionListener
{
    protected $client;

    public function __construct(ClientLoader $client)
    {
        $this->client = $client;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof HttpException) {
            return;
        }

        $this->client->notifyOnException($exception);
        error_log($exception->getMessage().' in: '.$exception->getFile().':'.$exception->getLine());
    }
}
