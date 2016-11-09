<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];

    public function tree(){
        $cate = $this->orderBy('cate_order','asc')->get();
        return $this->getTree($cate,'cate_id','cate_pid',0,'cate_name');
    }

    public function getTree($data,$field_id='id',$field_pid='pid',$order=0,$field_name){
        $arr = [];
        foreach($data as $k=>$v){
            if(intval($v->$field_pid) == $order){
                $arr[] = $data[$k];
                foreach($data as $m=>$n){
                    if($n->$field_pid == $v->$field_id){
                        $data[$m][$field_name] = '|— '.$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        
        return $arr;
    }

    public function articles(){
        
    }
}
