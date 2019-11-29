<?php declare(strict_types = 1);

namespace App\Game\Tool;


class Scissor extends AbstractTool
{

    protected function evaluate(AbstractTool $tool): int
    {
        return $tool->evaluateScissor($this);
    }

    protected function evaluateScissor(AbstractTool $tool) : int
    {
        return self::DEUCE;
    }

    protected function evaluateStone(AbstractTool $tool) : int
    {
        return self::LOSS;
    }

    protected function evaluatePaper(AbstractTool $tool) : int
    {
        return self::WIN;
    }
}
