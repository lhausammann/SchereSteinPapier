<?php declare(strict_types = 1);


namespace Game;


class ConsolePlayer extends Player
{
    protected $toolName = '';
    public function __construct(string $name, string $chosenToolName) {
        parent::__construct($name);
        $this->toolName = $chosenToolName;
    }

    // $what is the name of the chosen tool
    public function choose()
    {
        foreach(self::$allowedTools as $key => $tool) {
            if (strtolower($this->toolName) === strtolower($key)) {
                return new $tool;
            }
        }
    }
}