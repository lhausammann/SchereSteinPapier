<?php declare(strict_types = 1);

namespace Game\Tool;


class Paper extends AbstractTool
{

    public function evaluate(AbstractTool $tool): int
    {
        return $tool->evaluatePaper(); // inverse relation(!)
    }

    protected function evaluateScissor() : int
    {
        return self::LOSS;
    }

    protected function evaluateStone() : int
    {
        return self::WIN;
    }

    protected function evaluatePaper() : int
    {
        return self::DEUCE;
    }
}