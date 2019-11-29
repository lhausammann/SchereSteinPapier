<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Game\Game;
use App\Game\Player;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use App\Game\Tool\Scissor;
use App\Game\Tool\Paper;
use App\Game\Tool\Stone;

class AppCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:play';
    protected $toolMap = [];

    protected function configure()
    {

        $this->toolMap = ['scissor' => new Scissor(), 'stone' => new Stone(), 'paper' =>new Paper()];
        $this
            ->addArgument('choice',  InputArgument::REQUIRED, 'scissor,paper,stone,')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $game = new Game('You');
        $info = $game->play($input->getArgument('choice'));
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