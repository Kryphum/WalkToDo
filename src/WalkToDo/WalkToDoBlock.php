<?php


use WalkToDo\WalkToDo;
use WalkToDo\utils\WalkToDoUtils;


class WalkToDoBlock
{

    public $pos;
    public $commands;
    public $plugin;


    public function __construct( \pocketmine\Level\Position $pos, array $commands, WalkToDo $plugin )
    {

        $this->pos = $pos;
        $this->commands = $commands;
        $this->plugin = $plugin;

    }


    public function getCommands()
    {

        return $this->commands;

    }


    public function setCommands( array $commands )
    {

        $this->commands = $commands;

    }


    public function executeCommands( \pocketmine\Player $player )
    {

        foreach( $this->commands as $command )
        {

            if( end(explode( " ", $command ) ) === "%console" )
            {

                $this->plugin->getServer()->dispatchCommand( new \pocketmine\command\ConsoleCommandSender(), WalkToDoUtils::parseString( $command, $player ) );

                return true;

            }
            else
            {

                $this->plugin->getServer()->dispatchCommand( $player, WalkToDoUtils::parseString( $command, $player) );

            }

        }

    }

}