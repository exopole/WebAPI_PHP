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

        Message::addSuccess('Connection success !');
    }

}