<?php


namespace WalkToDo;


use pocketmine\plugin\PluginBase;

use pocketmine\level\Level;
use pocketmine\level\Position;

use WalkToDo\WalkToDoBlock;


class WalkToDo extends PluginBase
{
  
  public $cfg;
  public $blocks;
  
  
  public function onEnable()
  {
    
    $this->saveDefaultConfig();
    $this->cfg = $this->getConfig();
    
    $this->getServer()->getPluginManager()->registerEvents( new \WalkToDo\EventListener( $this ), $this );

    // set command executors
    $this->getCommand( "walktodo" )->setExecutor( new \Command\WalkToDoCommand( $this ), $this );

    // get all the blocks in $this->blocks
    $this->blocks = array();
    $this->parseBlocks();
    
  }

  
  public function getCfg()
  {

    return $this->cfg;

  }


  public function parseBlocks()
  {

    foreach( $this->cfg->get("blocks") as $block )
    {

        $coords = $block["x"] . ":" . $block["y"] . ":" . $block["z"] . ":" . $block["level"];
        $this->blocks[$coords] = new WalkToDoBlock( new Position( $block["x"], $block["y"], $block["z"], $this->getServer()->getLevelByName( $block["level"] ) ), $block["commands"], $this, count($this->blocks) ); // WalkToDoBlock class takes an instance of Position, an array of commands, an instance of WalkToDo, and an id

    }

  }


  public function getBlock( $x, $y, $z, Level $level )
  {

    $coords = $x . ":" . $y . ":" . $z . ":", $level->getName();
    return isset( $this->blocks[$coords] ) ? $this->blocks[$coords] : false; // returns the WalkToDo block if it exists, otherwise false

  }


  public function addBlock( Position $pos, array $commands )
  {

    $coords = $pos->getX() . ":" . $pos->getY() . ":" . $pos->getZ() . ":" . $pos->getLevel();
    if( ! isset( $this->blocks[$coords] ) )
    {

        $this->blocks[$coords] = new WalkToDoBlock( $pos, $commands, $this, count( $this->blocks ) );
        
        $blocks = $this->cfg->get("blocks");
        $blocks[$this->blocks[$coords]->getId()] = array(
            "x" => $pos->getX();
            "y" => $pos->getY();
            "z" => $pos->getZ();
            "level" => $pos->getLevel()->getName();
            "commands" => $commands;
        );
        $this->cfg->set( "blocks", $blocks );
        $this->cfg->save();

    }
    else
    {

        return false;

    }

  }


  public function removeBlock(  )
  
}


?>
