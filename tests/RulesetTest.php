<?php declare(strict_types=1);

use Game\Player;
use Game\Tool\Paper;
use Game\Tool\Scissor;
use Game\Tool\Stone;

use PHPUnit\Framework\TestCase;


class RulesetTest extends TestCase
{
    public function testPlayerChooses()
    {
        $a = new Player("A");
        $tool = $a->choose();
        $this->assertTrue(Player::isAllowedTool($tool));
    }

    public function testPlayerName()
    {
        $player = new Player("robot");
        $this->assertEquals('robot', $player);
    }

    public function testToolHaveNames()
    {
        $scissor = new Scissor();
        $paper = new Paper();
        $stone = new Stone();
        $this->assertEquals('Scissor', $scissor->getName());
        $this->assertEquals('Stone', $stone->getName());
        $this->assertEquals('Paper', $paper->getName());
    }

    public function testStoneHitsScissor()
    {
        $scissor = new Scissor();
        $stone = new Stone();
        $this->assertTrue($stone->wins($scissor), 'stone must win against scissor');
        $this->assertTrue($scissor->looses($stone), 'scissor must loose against stone');
    }

    public function testScissorHitsPaper()
    {
        $scissor = new Scissor();
        $paper = new Paper();
        $this->assertTrue($scissor->wins($paper), 'scissor must win against paper');
        $this->assertTrue($paper->looses($scissor), 'paper must loose against scissor');
    }

    public function testPaperHitsStone()
    {
        $paper = new Paper();
        $stone = new Stone();
        $this->assertTrue($paper->wins($stone), 'paper must win against stone');
        $this->assertTrue($stone->looses($paper), 'stone must loose against paper');
    }

    public function testDeuce()
    {
        $paper = new Paper();
        $scissor = new Scissor();
        $stone = new Stone();

        $this->assertTrue($scissor->deuce($scissor));
        $this->assertTrue($paper->deuce($paper));
        $this->assertTrue($stone->deuce($stone));
    }
}