<?php declare (strict_types=1);

namespace Game;

use Game\Tool\Scissor;
use Game\Tool\Paper;
use Game\Tool\Stone;
use Game\Tool\AbstractTool;


class Player
{
    public static $allowedTools = ['scissor' => Scissor::class, 'stone' => Stone::class, 'paper' => Paper::class];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function isAllowedTool(AbstractTool $tool) : bool
    {
        return in_array(get_class($tool), self::$allowedTools);
    }

    public function choose() : AbstractTool
    {
        $class =  array_values(self::$allowedTools)[random_int(0,2)];
        return new $class;
    }

    public function __toString() : string
    {
        return $this->name;
    }
}