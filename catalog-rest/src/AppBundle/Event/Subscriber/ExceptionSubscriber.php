<?php

namespace AppBundle\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
           KernelEvents::EXCEPTION => array(
               array('controllerAccessException', 0),
           )
        );
    }

    public function controllerAccessException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $message = $exception->getMessage();
        if ($exception instanceof InsufficientAuthenticationException) {
            throw new AccessDeniedHttpException($message);
        }
    }
}
