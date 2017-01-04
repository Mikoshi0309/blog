<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 2017/1/4
 * Time: 10:35
 */
namespace App;

class MenuPresenter
{
    public function menu(){
        $menu = config('menu');
        $menuString = '';
        foreach($menu as $mlist){
            $count = count($mlist);
            if($count>1){
                $menuString .= $this->childmenu($mlist);
            }else{
                $menuString .= $this->parentmenu($mlist);
            }
        }
        return $menuString;
    }

    private function childmenu($mlist){
        $string = '';
        $lstring = '';
        $string .= '<li>';
        $string .= '<h3><i class="'.$mlist['tree_title']['icon'].'"></i>'.$mlist['tree_title']['name'].'</h3>';
        $string .= '<ul class="sub_menu">%s</ul>';
        unset($mlist['tree_title']);
        foreach($mlist as $route=>$menu){
            $lstring .= '<li><a href="{{ url("'.$route.'") }}" target="main"><i class="'.$menu['icon'].'"></i>'.$menu['name'].'</a></li>';
        }
        $string .='</li>';
        $string = sprintf($string,$lstring);
        return $string;

    }

    private function parentmenu($mlist){
        $string = '';
        foreach($mlist as $route=>$value){
            $string .="<li><a href=\"{$route}\"><h3>{$value['name']}</a></li>";
        }
        return $string;
    }
}