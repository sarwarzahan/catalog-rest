<?php

namespace AppBundle\Event\Listener;

use AppBundle\Exception\HttpContentTypeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ContentTypeListener
{
    const MIME_TYPE_APPLICATION_JSON = 'application/json';

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->headers->contains('Content-type', self::MIME_TYPE_APPLICATION_JSON)) {
            return true;
        }

        if ($request->getMethod() === Request::METHOD_GET) {
            return true;
        }

        throw new HttpContentTypeException();
    }
}
