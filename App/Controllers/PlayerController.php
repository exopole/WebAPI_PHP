<?php

namespace Controllers;

use Kernel\Controller;

use Models\PlayerModel;
use Models\Message;
use phpseclib\Crypt\RSA;

use \Datetime;

class PlayerController extends Controller
{
	//http://phpseclib.sourceforge.net/
	public $plaintext = "THEGreatWizardTournament";

	public function getPlayerTest($request,$response, $args)
	{
		Message::addSuccess('success token !');
	}

    public function getPlayer($request,$response, $args)
    {
        $player = PlayerModel::findFirst(["player_name" => $_POST["username"]]);
        if($player)
        {

			$newrsa = new RSA();
    		$newrsa->loadKey($_POST["token"]);
    		$encrypt = $newrsa->encrypt($plaintext);
    		$newrsa->loadKey($player->player_token);

          	if($plaintext == $newrsa->decrypt($encrypt))
          	{
                Message::addSuccess('success token !');

                unset($player->player_mdp);
                unset($player->player_token);
                unset($player->player_mail);
                self::setContent($player);
            }
            else{
                Message::addWarning('Fail token!');
            }
            Message::addSuccess('Player trouvé !');
        }
        else{
            Message::addWarning("La connection ne c\"est pas effectué");
        }
        
    }

    public function getLeaderBoard($request,$response, $args)
    {
        $players = PlayerModel::findAll();

        foreach ($players as $player) {
    		unset($player->player_mdp);
            unset($player->player_token);
            unset($player->player_mail);
        }

        self::setContent($players);

        
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
    		$_SESSION['token'] = PlayerModel::defineId();

    		$newPlayer->player_token = $privatekey;
    		
    		$newPlayer->store();
    		Message::addSuccess('Inscription success !');
    		$player = $newPlayer;


    		$player->player_token = $publickey; 



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
    	$rsa = new RSA();
    		extract($rsa->createKey());
    		$_SESSION['token'] = PlayerModel::defineId();

    	if($player && $player->player_mdp == $_POST["mdp"] ){

    		


            $player->player_token = $privatekey;
            Message::addWarning(new DateTime());
    		$player->player_date_last_connection = new DateTime();
    		$player->store();

    		$sendPlayer = $player;
    		$sendPlayer->player_token = $publickey;
    		unset($sendPlayer->player_mdp);

        	self::setContent($sendPlayer);

    		// $newrsa = new RSA();
    		// $newrsa->loadKey($publickey);
    		// $encrypt = $newrsa->encrypt($plaintext);
    		// $newrsa->loadKey($privatekey);
    		// if($plaintext == $newrsa->decrypt($encrypt))
    		// {
    		// 	Message::addSuccess('success token !');
    		// }
    		// else
    		// {
    		// 	Message::addWarning('fail token !');

    		// }
    	}

    	else {
    		Message::addWarning("joueur non trouvé. Vérifié votre pseudo et votre mot de passe");
    	}

        
    }

    public function setScore($request,$response, $args)
    {
        $player = PlayerModel::findFirst(["player_name" => $_POST["username"]]);
        if($player)
        {
            $newrsa = new RSA();
            $newrsa->loadKey($publickey);
            $encrypt = $newrsa->encrypt($plaintext);
            $newrsa->loadKey($privatekey);
            if($plaintext == $newrsa->decrypt($encrypt))
            {
                Message::addSuccess('success token !');

                if($_POST["1vall"]){
                	$player->player_1vall = $_POST["1vall"];
                }
                if($_POST["2v2"]){
                	$player->player_2v2 = $_POST["2v2"];
                }
                if($_POST["3v3"]){
                	$player->player_3v3 = $_POST["3v3"];
                }
                if($_POST["4v4"]){
                	$player->player_4v4 = $_POST["4v4"];
                }

                $player->store();

                unset($player->player_mdp);
                unset($player->player_token);
                unset($player->player_mail);
                self::setContent($player);
            }
            else{
                Message::addSuccess('Fail token!');
            }
            Message::addSuccess('Infos retrieve success !');
        }
        else{
            Message::addWarning("La connection ne c\"est pas effectué");
        }

        
    }

}