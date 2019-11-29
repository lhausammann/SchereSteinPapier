<?php declare(strict_types = 1);

namespace Game;

use Game\Tool\AbstractTool;
use Game\Tool\Scissor;
use Game\Tool\Stone;
use Game\Tool\Paper;

class Game
{
    protected static $toolMap = [];
    protected $player1;
    protected $player2;

    public function __construct(Player $player1, Player $player2)
    {
        self::$toolMap = ['scissor' => new Scissor(), 'stone' => new Stone(), 'paper' => new Paper()];
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    public static function getTools() : array {
        return self::$toolMap;
    }

    public function play()
    {
        $tool1 = $this->player1->choose();
        $tool2 = $this->player2->choose();

        if (!$tool1) {
            throw new \Exception('Player1: Select either one of paper,scissor,stone. Given: '. $tool1);
        }

        if (!$tool2) {
            throw new \Exception('Player2: Select either one of paper,scissor,stone. Given: '. $tool2);
        }

        if ($tool1->wins($tool2)) {
            return new Info($this->player1, $this->player2, $tool1, $tool2, AbstractTool::WIN);
        } elseif ($tool1->looses($tool2)) {
            return new Info($this->player1, $this->player2, $tool1, $tool2, AbstractTool::LOSS);
        } else {
            return new Info($this->player1, $this->player2, $tool1, $tool2, AbstractTool::DEUCE);
        }
    }
}

/**
 * @internal WinnerInfo
 */
class Info
{
    private $human;
    private $robot;
    private $humanChoice;
    private $roboChoice;
    private $state;

    private $message;

    public function __construct($human, $robot, $humanChoice, $roboChoice, $winnerState)
    {
        $this->state = $winnerState;

        if ($winnerState === AbstractTool::WIN) {
            $this->message = sprintf('%s wins against %s beating %s with %s', $human, $robot, $roboChoice, $humanChoice);
        } elseif($winnerState === AbstractTool::LOSS) {
            $this->message = sprintf('%s looses against %s beaten by %s using %s', $human, $robot, $roboChoice, $humanChoice);
        } else {
            $this->message = sprintf("Deuce! Both players used %s and %s.", $humanChoice, $roboChoice);
        }
    }

    public function getMessage() : string {
        return $this->message;
    }

    public function isWin() {
        return $this->state === AbstractTool::WIN;
    }

    public function deuce() {
        return $this->state === AbstractTool::DEUCE;
    }

    public function loose() {
        return !$this->isWin();
    }
}