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
	//public $plaintext = "THEGreatWizardTournament";
	

	public function getPlayerTest($request,$response, $args)
	{
		$keypair = sodium_crypto_box_keypair();


        while (strpos($keypair, '#') !== false) {
            $keypair = sodium_crypto_box_keypair();
        }
        $public_key = sodium_crypto_box_publickey($keypair);
        $secret_key = sodium_crypto_box_secretkey($keypair);

        $message=  'Contain good text';
        $encrypted_text = sodium_crypto_box_seal($message, $public_key);
        $decrypted_text = sodium_crypto_box_seal_open($encrypted_text, $keypair);

        $keypair2 = sodium_crypto_box_keypair_from_secretkey_and_publickey(
            $secret_key,
            $public_key
        );
        $decrypted_text2 = sodium_crypto_box_seal_open($encrypted_text, $keypair2);
        //echo '<div>'.gettype($keypair).'</div>';
        //echo '<div>'.$keypair.'</div>';
        echo '<div>'.gettype($public_key).'</div>';
        echo '<div>'.$public_key.'</div>';
        echo '<div>'.gettype($secret_key).'</div>';
        echo '<div>'.$secret_key.'</div>';

        // echo '<div>'.$encrypted_text.'</div>';
        // echo '<div>'.$decrypted_text.'</div>';
        echo '<div>'.$decrypted_text2.'</div>';
	}

    public function getPlayer($request,$response, $args)
    {
        $plaintext2 = "THEGreatWizardTournament";
        $player = PlayerModel::findFirst(["player_name" => $_POST["username"]]);
        if($player)
        {
            unset($player->player_mdp);
            unset($player->player_token);
            unset($player->player_mail);
            self::setContent($player);

			// $newrsa = new RSA();
   //  		$newrsa->loadKey($_POST["token"]);
            //Message::addWarning($_POST["token"] ."<<<<<<<" . $newrsa->getPublicKey());
    		// $encrypt = $newrsa->encrypt($plaintext2);
    		// $newrsa->loadKey($player->player_token);

          	// if($plaintext2 == $newrsa->decrypt($encrypt))
          	// {
                //Message::addSuccess('success token !');

            // }
            // else{
            //     Message::addWarning('Fail token!');
            //     self::setContent($newrsa->getPublicKey() . $newrsa->getPrivateKey());
            // }

            // $public_key = $_POST["token"];
            // $secret_key = $player->player_token;
            // $keypair2 = sodium_crypto_box_keypair_from_secretkey_and_publickey(
            //     $secret_key,
            //     $public_key
            // );

            // $encrypted_text = sodium_crypto_box_seal($plaintext2, $public_key);

            // if($plaintext2 === sodium_crypto_box_seal_open($encrypted_text, $keypair2)){

            //     Message::addSuccess('token good !');

            // }
            // else{
            // Message::addWarning("Token not good");

            // }

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

    		$newPlayer->player_token = $privatekey;
            $newPlayer->player_date_last_connection = (new DateTime())->format('Y-m-d');
    		$newPlayer->player_date_inscription = (new DateTime())->format('Y-m-d');
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
        $rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_XML);
        $rsa->setPublicKeyFormat(RSA::PUBLIC_FORMAT_XML);
		extract($rsa->createKey());

        // $keypair = sodium_crypto_box_keypair();

        // echo "cpicpi   ";
        // //while (strpos($keypair, '#') !== false) {
        //   //  $keypair = sodium_crypto_box_keypair();
        

        // echo "cpicpi2";

        // $public_key = sodium_crypto_box_publickey($keypair);
        // $secret_key = sodium_crypto_box_secretkey($keypair);
        // echo "   cpicpi3";

    	if($player && $player->player_mdp == $_POST["mdp"] ){

    		


            $player->player_token = $privatekey;
            $player->player_token = $secret_key;
            //Message::addWarning((new DateTime())->format('Y-m-d'));
    		$player->player_date_last_connection = (new DateTime())->format('Y-m-d');
    		$player->store();

    		$sendPlayer = $player;
            $sendPlayer->player_token = $publickey;
    		// $sendPlayer->player_token = $public_key;
    		unset($sendPlayer->player_mdp);

        	
            self::setContent($sendPlayer);

            $plaintext2 = "THEGreatWizardTournament";
    		// $newrsa = new RSA();
    		// $newrsa->loadKey($publickey);
    		// $encrypt = $newrsa->encrypt($plaintext2);
    		// $newrsa->loadKey($privatekey);
    		// if($plaintext2 == $newrsa->decrypt($encrypt))
    		// {
      //           // $keypair = sodium_crypto_box_keypair();
    		// 	Message::addSuccess("success");
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
        $plaintext = "THEGreatWizardTournament";
    	$tokenServer = "MiaouIStheWORLD";
        $player = PlayerModel::findFirst(["player_name" => $_POST["username"]]);
        if($player)
        {
            $newrsa = new RSA();
            $newrsa->loadKey($player->player_token);
            $newrsa->loadKey($newrsa->getPublicKey());
            //$newrsa->loadKey($_POST["token"]);
            $encrypt = $newrsa->encrypt($plaintext);
            //$newrsa->loadKey($player->player_token);

            

            if($_POST["token_server"] != $tokenServer){
            	Message::addWarning('Fail token server!');
				self::setContent( $_POST["token_server"] . '/ ' . $tokenServer);
            }
            else{
            	Message::addSuccess('success token server!');

                //var_dump(expression)
                if($_POST["score_1vall"]){
                	if($player->player_1vall ){
                		$player->player_1vall += $_POST["score_1vall"];
                	}

                	else{
                		$player->player_1vall = $_POST["score_1vall"];
                	}
                	if($player->player_1vall < 0)
                		$player->player_1vall = 0;

                }
                if($_POST["score_2v2"]){
                	if($player->player_2v2)
                		$player->player_2v2 += $_POST["score_2v2"];
                	else{
                		$player->player_2v2 = $_POST["score_2v2"];
                	}
                	if($player->player_2v2 < 0)
                		$player->player_2v2 = 0;
                }
                if($_POST["score_3v3"]){
                	if($player->player_3v3)
                		$player->player_3v3 += $_POST["score_3v3"];
                	else{
                		$player->player_3v3 = $_POST["score_3v3"];

                	}
                	if($player->player_3v3 < 0)
                		$player->player_3v3 = 0;
                }
                if($_POST["score_4v4"]){
                	if($player->player_4v4)
                		$player->player_4v4 += $_POST["score_4v4"];
                	else{

                		$player->player_4v4 += $_POST["score_4v4"];
                	}
                	if($player->player_4v4 < 0)
                		$player->player_4v4 = 0;
                }

                $player->store();

                unset($player->player_mdp);
                unset($player->player_token);
                unset($player->player_mail);
                self::setContent($player);
            }
            if($plaintext == $newrsa->decrypt($encrypt) )
            {
                Message::addSuccess('success token !');
            }
            else{
                //Message::addWarning('Fail token!');
            }
            Message::addSuccess('Infos retrieve success !');
        }
        else{
            Message::addWarning("La connection ne c\"est pas effectué");
        }

        
    }

}