<?php declare(strict_types = 1);

namespace App\Game\Tool;


class Stone extends AbstractTool
{

    protected function evaluate(AbstractTool $tool): int
    {
        return $tool->evaluateStone($this);
    }

    protected function evaluateScissor(AbstractTool $tool) : int
    {
        return self::WIN;
    }

    protected function evaluateStone(AbstractTool $tool) : int
    {
        return self::DEUCE;
    }

    protected function evaluatePaper(AbstractTool $tool) : int
    {
        return self::LOSS;
    }
}
