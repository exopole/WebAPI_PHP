<?php
/**
 * Created by PhpStorm.
 * User: usersio
 * Date: 08/11/18
 * Time: 15:40
 */

namespace Kernel;


abstract class DataObject extends \ErwanG\DataObject
{
    abstract public function canDelete();

}