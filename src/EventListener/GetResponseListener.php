<?php declare(strict_types=1);

namespace App\EventListener;

use Game\ConsolePlayer;
use Game\Game;
use Game\Info;
use Game\Player;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;


class GetResponseListener
{
    const EVENT_PLAYED = 'ssp.played';

    private $dispatcher = null;

    public function __construct(EventDispatcherInterface $eventDispatcher) {
        $this->dispatcher = $eventDispatcher;
    }

    public function __invoke(RequestEvent $e) : void
    {

        if ($choice = $e->getRequest()->query->get('choice', '')) {
            $game = new Game(new ConsolePlayer('You', $choice), new Player('Robo')); // could be we start some session etc, so call it every time.


            $this->dispatcher->dispatch($playEvent = new PlayedEvent($game->play()), self::EVENT_PLAYED);
            $info = $playEvent->getInfo();

            $html = '<html><h1>'.$info->getMessage().'</h1>'.$this->createSelect().'</html>';
        } else {
            $html = '<html> Bitte wählen:<br />' . $this->createSelect();
        }

        $response = new Response();
        $response->setContent($html);
        $e->setResponse($response);
    }

    public function createSelect() : string
    {
        $tools = Game::getTools();
        // create a listing
        $html = '<form method="GET" action="/"><select name="choice">';
        foreach ($tools as $key => $tool) {
            $html .= '<option value="' . $key . '">' . $tool . '</option>';
        }
        return $html . '</select><input type="submit" /></form>';
    }
}

class PlayedEvent {
    private $info;
    public function __construct(Info $info) {
        $this->info = $info;
    }

    public function setInfo(Info $info) {
        $this->info = $info;
    }
    public function getInfo() {
        return $this->info;
    }
}