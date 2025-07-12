<?php

namespace App\Shared\Application\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::REQUEST, priority: 20)]
class LocaleListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        
        if (!$request->hasPreviousSession()) {
            return;
        }

        if ($locale = $request->getSession()->get('_locale')) {
            $request->setLocale($locale);
        }
    }
}
