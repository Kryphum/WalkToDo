<?php


namespace WalkToDo;


use pocketmine\plugin\PluginBase;


class WalkToDo extends PluginBase
{
  
  public $connection;
  public $cfg;
  public $pingTask;
  public $blocks;
  
  
  public function onEnable()
  {
    
    $this->cfg = $this->getConfig()->getAll();
    
    $mysql_creds = $this->cfg['mysql']; // array of mysql credentials
    $this->connection = new \mysqli( $mysql_creds['host'], $mysql_creds['username'], $mysql_creds['password'], $mysql_creds['database'], $mysql_creds['port'] );
    
    $this->getDatabase()->query
    
    $this->getServer()->getPluginManager()->registerEvents(new \WalkToDo\EventListener($this), $this);
    $this->getServer()
    
  }
  
  
  public function getDatabase()
  {
    
    if( $this->connection instanceof \mysqli )
    {
      return $this->connection;
    }
    else
    {
      return false;
    }
    
  }
  
}


?>
