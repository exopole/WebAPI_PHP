<?php

namespace Controllers;

use Kernel\Controller;

use Models\PlayerModel;
use Models\Message;
use phpseclib\Crypt\RSA;

class PlayerController extends Controller
{
	//http://phpseclib.sourceforge.net/

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

    		$rsa = new RSA();
    		extract($rsa->createKey());
    		$privatekey = $rsa->getPrivateKey();
    		$publickey = $rsa->getPublicKey();
    		$_SESSION['token'] = PlayerModel::defineId();

    		$newPlayer->player_token = $privatekey;
    		
    		$newPlayer->store();
    		Message::addSuccess('Inscription success !');
    		$player = $newPlayer;


    		$player->token = $publickey; 



    		unset($player->player_mdp);
        	self::setContent($player);

        	$newrsa = new RSA();
        	$newrsa->loadKey($privatekey); 
        	$signature = $rsa->sign($_SESSION['token');
        	if($rsa->verify($_SESSION['token'], $signature) )
        		Message::addSuccess('success !');
        	else{
        		Message::addSuccess('Fail !');
        	}


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
    		$_SESSION['token'] = $player->player_token;
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