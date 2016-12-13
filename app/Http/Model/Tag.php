<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    static $tags;
    public $timestamps = false;
    protected $guarded = [];

    public function articles(){
        return $this->belongsToMany(Article::class);
    }




    public static function getTagArr(){
        $data = self::getTagModeArr();
        if(!empty($data)){
            foreach($data as $v){
                self::$tags[$v->id] = $v->name;
            }
        }
        return self::$tags ? self::$tags : [];
    }

    public static function getTagNameById($id){
        if(!isset(self::$tags[$id])){
            $tag = self::find($id);
            if(!empty($tag)){
                self::$tags[$id] = $tag->name;
            }
        }
        return isset(self::$tags[$id]) ? self::$tags[$id] : '';
    }

    public static function getTagModeArr(){
        return self::all();
    }

    //获取标签插件所需得列表数据
    public static function getTagStringAll(){
        $tags = self::getTagModeArr();
        return !empty($tags) ? self::TagModelConversionTagString($tags):null;
    }

    public static function getTagModeByTagIds($ids){
        $tagids = explode(',',$ids);
        return !empty($tagids) ? self::find($tagids):null;
    }

    /**
     * 根据标签id串获取标签插件所需得数据
     * @param $tagIds
     * @return null|string
     */

    public static function getTagStringByTagIds($ids){
        $tags = getTagModeByTagIds($ids);
        return !empty($tags) ? self::TagModelConversionTagString($tags):null;
    }

    public static function TagModelConversionTagString($tags){
        $tag = '';
        if(!empty($tags)){
            foreach($tags as $v){
                $tag .= "'{$v->name}',";
            }
            $tag = rtrim($tag,',');
        }
        return $tag;
    }

    public static function SetArticleTags($tags){
        $tagarr = [];
        if(isset($tags)){
            $tagarr = explode(',',$tags);
        }
        $tagids = [];
        if(!empty($tagarr)){
            foreach($tagarr as $v){
                $v = trim($v);
                $v = filterTagName($v);
                $tag = self::where('name',$v)->get();
                if(isset($tag->id)){
                    $tag->t_number = $tag->t_number+1;
                    $tag->save();
                    $tagids[] = $tag->id;
                }else{
                    $tagids[] = self::insertGetId(['name'=>$v,'t_number'=>1]);
                }
            }
            unset($tag);
        }
        return implode(',',$tagids);


    }

    public static function getHotTag($limit){
        return self::order('t_number','desc')->limit($limit)->get();
    }
    
    public static function filterTagName($name){
        return str_replace('/\/|\\|\'|\"|\s/','',$name);
    }
    
}
