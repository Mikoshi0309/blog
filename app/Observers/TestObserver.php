<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 2016/12/21
 * Time: 17:05
 */
namespace App\Observers;
use App\Http\Model\Article;

class TestObserver
{
    function saved($test){
        Article::where('art_id',$test->art_id)->update(['art_description'=>'swj']);
    }
}