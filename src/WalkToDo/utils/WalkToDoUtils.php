<?php


class WalkToDoUtils
{

    public static function parseString( $string, \pocketmine\Player $player )
    {

        $search = array( "\{player\}", "\{x\}", "\{y\}", "\{z\}", "\{nametag\}" );
        $replace = array( $player->getName(), $player->getX(), $player->getY(), $player->getZ(), $player->getNameTag() );
        return str_replace( $search, $replace, $string );

    }

}