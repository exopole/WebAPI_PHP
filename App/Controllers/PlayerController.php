<?php

namespace Controllers;

use Kernel\Controller;

use Models\PlayerModel;
use Models\Message;

class PlayerController extends Controller
{

    public function getPlayer($request,$response, $args)
    {
        $player = PlayerModel::findFirst(["player_name" => $args["username"]]);
        self::setContent($player);
        //$game = new stdClass;

        Message::addSuccess('Connection success !');
    }


    public function getPlayerName($request,$response, $args)
    {
        $player = PlayerModel::findFirst(["player_name" => $args["username"]]);
        self::setContent($player->player_name);

        Message::addSuccess('Connection success !');
    }

    public function createPlayer($request, $response, $args)
    {
        var_dump($_POST);

    	$player = PlayerModel::findFirst(["player_name" => $_POST['username']]);
        self::setContent($_POST['username']);
        self::setContent($_POST);

    	// if(!$player)
    	// {
    	// 	$newPlayer = PlayerModel::create();
    	// 	$newPlayer->id = PlayerModel::defineId();
    	// 	$newPlayer->player_name = $_POST["username"];
    	// 	$newPlayer->store();
    	// }
    	// else
    	// {
    	// 	Message::addWarning("Ce joueur...");
    	// }
    }

}