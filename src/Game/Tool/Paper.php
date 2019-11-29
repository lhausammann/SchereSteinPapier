<?php declare(strict_types = 1);

namespace App\Game\Tool;


class Paper extends AbstractTool
{

    public function evaluate(AbstractTool $tool): int
    {
        return $tool->evaluatePaper($this); // inverse relation(!)
    }

    protected function evaluateScissor(AbstractTool $tool) : int
    {
        return self::LOSS;
    }

    protected function evaluateStone(AbstractTool $tool) : int
    {
        return self::WIN;
    }

    protected function evaluatePaper(AbstractTool $tool) : int
    {
        return self::DEUCE;
    }
}