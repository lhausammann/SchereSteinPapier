<?php declare(strict_types=1);

namespace App\EventListener;

use Game\ConsolePlayer;
use Game\Game;
use Game\Player;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;


class GetResponseListener2
{
    public function __invoke(ResponseEvent $e) : void
    {
        echo "get response listener2";
    }
}