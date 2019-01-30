<?php
/**
 * Created by PhpStorm.
 * User: usersio
 * Date: 08/11/18
 * Time: 15:22
 */

namespace Kernel;

class Controller
{
    protected static $content=null;

    public static function setContent($c){
        self::$content=$c;
    }

    public static function getContent(){
        return self::$content;
    }
}