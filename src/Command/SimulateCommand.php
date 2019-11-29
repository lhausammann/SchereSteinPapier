<?php

namespace App\Command;

use Game\Game;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Game\Player;
use Game\Tool\Scissor;
use Game\Tool\Paper;
use Game\Tool\Stone;

class SimulateCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:simulate';
    protected $toolMap = [];

    protected function configure()
    {
        $this->toolMap = ['scissor' => new Scissor(), 'stone' => new Stone(), 'paper' =>new Paper()];
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $game = new Game(new Player("Robi"), new Player("Tobi"));
        $info = $game->play('');
        if ($info->isWin()) {
            $output->writeln('<info>'.$info->getMessage().'</info>');
        } elseif ($info->deuce()) {
            $output->writeln('<comment>'.$info->getMessage().'</comment>');

        } else {
            $output->writeln('<error>'.$info->getMessage().'</error>');
        }
        return 0;
    }
}