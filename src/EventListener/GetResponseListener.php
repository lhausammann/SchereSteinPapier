<?php declare(strict_types=1);

namespace App\EventListener;

use Game\ConsolePlayer;
use Game\Game;
use Game\Player;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;


class GetResponseListener
{
    public function __invoke(RequestEvent $e) : void
    {
        if ($choice = $e->getRequest()->query->get('choice', '')) {
            $game = new Game(new ConsolePlayer('You', $choice), new Player('Robo')); // could be we start some session etc, so call it every time.

            $info = $game->play();

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