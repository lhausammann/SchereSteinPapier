<?php declare(strict_types = 1);


namespace Game;
use Game\Tool\AbstractTool;

class ConsolePlayer extends Player
{
    protected $toolName = '';
    public function __construct(string $name, string $chosenToolName) {
        parent::__construct($name);
        $this->toolName = $chosenToolName;
    }

    public function choose() : AbstractTool
    {
        foreach(self::$allowedTools as $key => $tool) {
            if (strtolower($this->toolName) === strtolower($key)) {
                return new $tool;
            }
        }
    }
}