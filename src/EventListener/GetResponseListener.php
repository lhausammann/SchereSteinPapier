<?php declare(strict_types=1);

namespace App\EventListener;

use App\Game\Game;
use App\Game\Tool\AbstractTool;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;


class GetResponseListener
{
    public function __invoke(RequestEvent $e) : void
    {
        $game = new Game(); // could be we start some session etc, so call it every time.
        if ($choice = $e->getRequest()->query->get('choice', '')) {

            $info = $game->play($choice);

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