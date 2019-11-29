<?php declare (strict_types=1);

namespace App\Game;

use App\Game\Tool\Scissor;
use App\Game\Tool\Paper;
use App\Game\Tool\Stone;
use App\Game\Tool\AbstractTool;


class Player
{
    public static $allowedTools = [Scissor::class, Stone::class, Paper::class];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function isAllowedTool(AbstractTool $tool)
    {
        return in_array(get_class($tool), self::$allowedTools);
    }

    public function choose()
    {
        $class =  self::$allowedTools[random_int(0,2)];
        return new $class;
    }

    public function __toString() : string
    {
        return $this->name;
    }
}