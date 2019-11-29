<?php declare(strict_types = 1);

namespace App\Game;

use App\Game\Tool\AbstractTool;
use App\Game\Tool\Scissor;
use App\Game\Tool\Stone;
use App\Game\Tool\Paper;

class Game
{
    protected static $toolMap = [];
    protected $userName = '';

    public function __construct($userName = 'Human')
    {
        self::$toolMap = ['scissor' => new Scissor(), 'stone' => new Stone(), 'paper' => new Paper()];
        $this->userName = $userName;
    }

    public static function getTools() : array {
        return self::$toolMap;
    }

    public function play($chosen)
    {
        $tool = self::$toolMap[$chosen] ?? null;
        if (!$tool) {
            throw new \Exception('Select either one of paper,scissor,stone. Given: '.$chosen);
        }
        $robo = new Player('Robot');
        $roboChoice = $robo->choose();
        $human = new Player($this->userName);


        if ($tool->wins($roboChoice)) {
            return new Info($human, $robo, $tool, $roboChoice, AbstractTool::WIN);
        } elseif ($tool->looses($roboChoice)) {
            return new Info($human, $robo, $tool, $roboChoice, AbstractTool::LOSS);
        } else {
            return new Info($human, $robo, $tool, $roboChoice, AbstractTool::DEUCE);
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