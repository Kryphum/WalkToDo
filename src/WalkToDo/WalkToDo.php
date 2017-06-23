<?php


namespace WalkToDo;


use pocketmine\plugin\PluginBase;

use pocketmine\level\Position;

use WalkToDo\WalkToDoBlock;


class WalkToDo extends PluginBase
{
  
  public $cfg;
  public $blocks;
  public $sessions;
  
  
  public function onEnable()
  {
    
    $this->saveDefaultConfig();
    $this->cfg = $this->getConfig();
    
    $this->getServer()->getPluginManager()->registerEvents( new \WalkToDo\EventListener( $this ), $this );

    // set command executors
    $this->getCommand( "walktodo" )->setExecutor( new \command\WalkToDoCommand( $this ), $this );

    // get all the blocks in $this->blocks
    $this->blocks = array();
    $this->parseBlocks();

    $this->sessions = array();
    
  }


  public function parseBlocks()
  {

    foreach( $this->cfg->get( "blocks" ) as $block )
    {

        $coords = $block["x"] . ":" . $block["y"] . ":" . $block["z"] . ":" . $block["level"];
        $this->blocks[$coords] = new WalkToDoBlock( new Position( $block["x"], $block["y"], $block["z"], $this->getServer()->getLevelByName( $block["level"] ) ), $block["commands"], $this ); // WalkToDoBlock class takes an instance of Position, an array of commands, and an instance of WalkToDo

        return true;

    }

  }


  public function getBlock( Position $pos )
  {

    $coords = $pos->getX() . ":" . $pos->getY() . ":" . $pos->getZ() . ":" . $pos->getLevel()->getName();
    return isset( $this->blocks[$coords] ) ? $this->blocks[$coords] : false; // returns the WalkToDoBlock instance if it exists, otherwise false

  }


  public function addBlock( Position $pos, array $commands )
  {

    $coords = $pos->getX() . ":" . $pos->getY() . ":" . $pos->getZ() . ":" . $pos->getLevel();
    if( ! isset( $this->blocks[$coords] ) )
    {

        $this->blocks[$coords] = new WalkToDoBlock( $pos, $commands, $this );
        
        $blocks = $this->cfg->get( "blocks" );
        $blocks[$coords] = array(
            "x" => $pos->getX(),
            "y" => $pos->getY(),
            "z" => $pos->getZ(),
            "level" => $pos->getLevel()->getName(),
            "commands" => $commands
        );
        $this->cfg->set( "blocks", $blocks );
        $this->cfg->save();

        return true;

    }
    else
    {

        return false;

    }

  }


  public function removeBlock( Position $pos )
  {

    $coords = $pos->getX() . ":" . $pos->getY() . ":" . $pos->getZ() . ":" . $pos->getLevel()->getName();
    unset( $this->blocks[$coords] );

    $blocks = $this->cfg->get( "blocks" );
    unset( $blocks[$coords] );
    $this->cfg->set( "blocks", $blocks );
    $this->cfg->save();

    return true;

  }


  public function updateBlock( Position $pos, array $commands )
  {

    $coords = $pos->getX() . ":" . $pos->getY() . ":" . $pos->getZ() . ":" . $pos->getLevel()->getName();
    $this->blocks[$coords]->setCommands( $commands );

    $blocks = $this->cfg->get( "blocks" );
    $blocks[$coords]["commands"] = $commands;
    $this->cfg->set( "blocks", $blocks );
    $this->cfg->save();

    return true;

  }

}


?>
