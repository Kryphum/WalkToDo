<?php


namespace WalkToDo;


use pocketmine\event\Listener;
use pocketmine\event\PlayerInteractEvent;
use pocketmine\event\PlayerMoveEvent;

use WalkToDo\WalkToDo;


class EventListener implements Listener
{

    public $plugin;
    

    public function __construct( WalkToDo $plugin )
    {

        $this->plugin = $plugin;

    }


    public function onInteract( PlayerInteractEvent $event )
    {

        $playerName = $event->getPlayer()->getName();
        $block = $event->getBlock();
        $coords = $block->getX() . ":" . $block->getY() . ":" . $block->getZ() . ":" . $block->getLevel()->getName();
        if( isset( $this->plugin->sessions[$playerName] ) )
        {

            if( ! isset( $this->plugin->blocks[$coords] ) )
            {
          
                $this->plugin->addBlock( $block, $this->sessions[$playerName] );

                return true;

            }
            else
            {

                $this->plugin->updateBlock( $block, $this->sessions[$playerName] );

                return true;

            }

        }

    }


    public function onMove( PlayerMoveEvent $event )
    {

        $player = $event->getPlayer();
        $coords = $player->getX() . ":" . $player->getY() . ":" . $player->getZ() . ":" . $player->getLevel()->getName();
        if( isset( $this->plugin->blocks[$coords] ) && $player->hasPermission( "walktodo.walk" ) )
        {

            $this->plugin->getBlock( $coords )->executeCommands( $player );

        }

    }

}