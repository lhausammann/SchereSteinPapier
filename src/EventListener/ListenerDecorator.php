<?php

namespace App\EventListener;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Log\Logger;

class ListenerDecorator
{
    private $decorated;

    public function __construct(LoggerInterface $logger)
    {
        $logger->info("Construct");
    }

    // invoke is a magic method which is tested against and won't be detected using call alone.
    public function __invoke($args) {

        return $this->decorated->__invoke($args);
    }

    public function __call(string $method, array $args) // : mixed
    {
        return call_user_func_array([$this->decorated, $method], $args);
    }

    public function decorate($originalListener) : void {
        echo 'decorates: ' . get_class($originalListener);
        $this->decorated = $originalListener;
    }
}