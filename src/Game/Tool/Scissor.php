<?php declare(strict_types = 1);

namespace Game\Tool;


class Scissor extends AbstractTool
{

    protected function evaluate(AbstractTool $tool): int
    {
        return $tool->evaluateScissor();
    }

    protected function evaluateScissor() : int
    {
        return self::DEUCE;
    }

    protected function evaluateStone() : int
    {
        return self::LOSS;
    }

    protected function evaluatePaper() : int
    {
        return self::WIN;
    }
}
