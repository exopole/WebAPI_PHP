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

    	if(!$player && $_POST["username"] && $_POST["mdp"])
    	{
    		$newPlayer = PlayerModel::create();
    		$newPlayer->id = PlayerModel::defineId();
    		$newPlayer->player_name = $_POST["username"];
    		$newPlayer->player_mdp = $_POST["mdp"];
    		
    		if($_POST["mail"])
    			$newPlayer->player_mail = $_POST["mail"];
    		
    		$newPlayer->player_token = uniqid();
    		
    		$newPlayer->store();
    		Message::addSuccess('Inscription success !');
    		$player = $newPlayer;
    		unset($player->player_mdp);
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
    		$player->player_token = uniqid();

    		$player->store();

    		$sendPlayer = $player;
    		unset($newPlayer->player_mdp);

        	self::setContent($sendPlayer);
    	}

    	else {
    		Message::addWarning("joueur non trouvé");
    	}

        
    }

}