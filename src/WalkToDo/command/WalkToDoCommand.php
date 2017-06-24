<?php


namespace WalkToDo\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;

use pocketmine\utils\TextFormat;

use WalkToDo\WalkToDo;
use WalkToDo\utils\WalkToDoUtils;


class WalkToDoCommand implements CommandExecutor
{

    public $plugin;


    public function __construct( WalkToDo $plugin )
    {

        $this->plugin = $plugin;

    }


    public function onCommand( Command $cmd, CommandSender $sender, $label, array $args )
    {

        if( $cmd->getName() == "walktodo" )
        {

            if( count( $args ) < 1 )
            {

                $sender->sendMessage( TextFormat::WHITE . "[WalkToDo] " . TextFormat::GOLD . "Usage: /walktodo <command> [| <command> [| <command>[...]]]");

                return true;

            }

            // user can add multiple commands with /walktodo command1 | command2 | command3 | etc
            foreach( $args as $key => $arg )
            {

                if( $arg === "|" )
                {

                    $command = WalkToDoUtils::arr_slice( $args, 0, $key + 1 );
                    $this->plugin->sessions[$sender->getName()][] = implode( " ", $command );

                }

                $this->plugin->sessions[$sender->getName()] = implode( " ", array_slice( $args, 0, count( $args ) ) );

            }

            $sender->sendMessage( TextFormat::WHITE . "[WalkToDo] " . TextFormat::GREEN . "Please tap a block to add the commands to!" );

        }

    }

}