<?php declare(strict_types = 1);

namespace Game\Tool;


class Stone extends AbstractTool
{

    protected function evaluate(AbstractTool $tool): int
    {
        return $tool->evaluateStone($this);
    }

    protected function evaluateScissor() : int
    {
        return self::WIN;
    }

    protected function evaluateStone() : int
    {
        return self::DEUCE;
    }

    protected function evaluatePaper() : int
    {
        return self::LOSS;
    }
}
