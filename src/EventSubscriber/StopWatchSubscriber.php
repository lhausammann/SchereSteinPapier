<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Kernel;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class StopWatchSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public function __construct (LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest', 10000
            ],
            KernelEvents::RESPONSE => [
                'onKernelResponse', -1000
            ]
        ];
    }

    public function onKernelRequest(RequestEvent $e) {
        $e->getRequest()->attributes->set('start', microtime(true));
    }

    public function onKernelResponse(ResponseEvent $e) {
        $start = $e->getRequest()->attributes->get('start');
        var_dump(microtime(true) - $start);
    }
}