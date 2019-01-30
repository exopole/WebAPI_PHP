<?php

namespace Controllers;

use Kernel\Controller;

use Models\Prop;
use Models\Message;

class Generator extends Controller
{

    public function getAll($request,$response, $args)
    {
        $props = Prop::findAll();
        self::setContent($props);

        Message::addSuccess('Connection success !');
    }

}