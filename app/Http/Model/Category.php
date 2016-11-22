<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];
    static $category = array();
    static $catedata = [
        0 => '顶级分类',
    ];
    public $html;


    //获取顶级分类
    public static function getTopCategory($num = 10){
        return  self::where('cate_pid',0)->get();
    }
    //获取分类列表
    public static function getCategoryDataMode(){
        $category = self::all();
        $data = catetree($category);
        return $data;
    }

    //此方法维护分类静态数组
    public static function getCategoryArr($cate_id){
        if(!isset(self::$category[$cate_id])){
            $cate = self::select('cate_name')->find($cate_id);
            if(empty($cate)){
                return flase;
            }
            self::$category[$cate_id] = $cate->cate_name;
        }
        return self::$category[$cate_id];
    }

    public static function getCategoryNameByCateId($cateid){
        $cate = self::getCategoryArr($cateid);
        return !empty($cate) ? $cate : "分类不存在";
    }
    //取得树形结构数据
    public static function getCategoryTree($cateDataFirstName=""){
        if($cateDataFirstName){
            self::$catedata[0] = $cateDataFirstName;
        }
        $data = self::getCategoryDataMode();
        foreach($data as $k=>$v){
            self::$catedata[$v->cate_id] = $v->html.$v->cate_name;
        }
        return self::$catedata;
    }
    //获取一个分类下全部的子分类id列表
    public static function getChildIdsList($data,$pid){
        static $chileIdsList = [];
        foreach($data as $k=>$v){
            if($pid == $v->pid){
                $childIdsList[] = $v->cate_id;
                self::getChildIdsList($data,$v->cate_id);
            }
        }
        return $chileIdsList;
    }

    //获取获取一个分类下全部的子分类id串
    public static function getChildIds($chileIdsList){
        return implode(',',$chileIdsList);
    }




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
        return $this->hasMany('App\Http\Model\Article','cate_id');
    }
}
