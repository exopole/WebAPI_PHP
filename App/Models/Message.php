<?php
/**
 * Created by PhpStorm.
 * User: usersio
 * Date: 08/11/18
 * Time: 14:31
 */

namespace Models;


class Message
{
    static private function add($text,$level)
    {
        if(!isset($_SESSION['__MESSAGE'])){
            $_SESSION['__MESSAGE']=[];
        }
        $_SESSION['__MESSAGE'][]=['text'=>$text,'level'=>$level];
    }

    static function addWarning($text)
    {
        self::add($text,'warning');
    }

    static function addSuccess($text)
    {
        self::add($text,'success');
    }

    static function addInformation($text)
    {
        self::add($text,'information');
    }
    static function addDanger($text)
    {
        self::add($text,'danger');
    }



    static function get()
    {
        if(!isset($_SESSION['__MESSAGE'])){
            $_SESSION['__MESSAGE']=[];
        }
        $data = $_SESSION['__MESSAGE'];
        $_SESSION['__MESSAGE']=[];
        return $data;
    }
}