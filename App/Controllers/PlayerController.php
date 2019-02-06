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
    	$player = PlayerModel::findFirst(["player_name" => $_POST['username']]);

    	if(!$player)
    	{
    		$newPlayer = PlayerModel::create();
    		$newPlayer->id = PlayerModel::defineId();
    		$newPlayer->player_name = $_POST["username"];
    		$newPlayer->player_mdp = $_POST["mdp"];
    		
    		if($_POST["mail"])
    			$newPlayer->player_mail = $_POST["mail"];
    		
    		if($_POST["token"])
    			$newPlayer->player_token = $_POST["token"];
    		
    		$newPlayer->store();
    		Message::addSuccess('Inscription success !');
        	self::setContent($player);


    	}
    	else
    	{
    		Message::addWarning("Ce joueur existe déjà");
    	}
    }

    public function connectPlayer($request, $response, $args)
    {
    	$player = PlayerModel::findFirst(["player_name" => $_POST["username"]]);

    	if($player){

        	self::setContent($player);
    	}

    	else {
    		Message::addWarning("joueur non trouvé");
    	}

        
    }

}