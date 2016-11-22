<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 2016/11/22
 * Time: 16:19
 */


if(!function_exists('catetree')){
    function catetree($data,$pid=0,$level=0,$html='-'){
        static $list = [];
        foreach($data as $k=>$v){
            if($v->cate_pid == $pid){
                if($level != 0){
                    $v->html = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$level);
                    $v->html .= '|';
                    $v->html .= str_repeat($html,$level);
                }
                $list[] = $v;
                catetree($data,$v->cate_id,$level+1);
            }
        }
        return $list;
    }
}