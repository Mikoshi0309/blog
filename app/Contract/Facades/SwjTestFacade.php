<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 2016/12/7
 * Time: 15:52
 */
namespace App\Contract\Facades;

use Illuminate\Support\Facades\Facade;

class SwjTest extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'swjtest';
    }
}