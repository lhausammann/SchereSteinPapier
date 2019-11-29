<?php
namespace Game\Tool;

abstract class AbstractTool
{
    const WIN = 1;
    const LOSS = -1;
    const DEUCE = 0;

    public function getName() : string {
        $parts = explode('\\', get_class($this));
        return array_pop($parts);
    }

    public final function play(AbstractTool $against) : int {
        // evaluation returns the double-ddispatched evaluation, which is the enemys score.
        return $this->evaluate($against) * -1;
    }

    public final function wins(AbstractTool $against) : bool {
        return $this->play($against) === self::WIN;
    }

    public final function looses(AbstractTool $against) : bool {
        return $this->play($against) === self::LOSS;
    }

    public final function deuce(AbstractTool $against) : bool {
        return $this->play($against) === self::DEUCE;
    }

    public function __toString()
    {
        return $this->getName();
    }

    abstract protected function evaluate(AbstractTool $tool) : int;

    abstract protected function evaluateScissor() : int;

    abstract protected function evaluateStone() : int;

    abstract protected function evaluatePaper() : int;


}