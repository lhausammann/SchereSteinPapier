<?php

namespace App\EventListener;

use Game\Game;
use Game\Info;
use Game\Player;
use Game\Tool\AbstractTool;

class AlwaysWinListener
{
    public function __invoke($event) {

        // @see #12345: Client complains about loosing sometimes
        $event->getInfo()->state = AbstractTool::WIN;
    }
}