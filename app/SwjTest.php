<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SwjTest extends Model
{
    protected $table = 'test';
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $guarded = [];
    public $timestamps = false;

    static public function savecol($data){
        foreach($data as $k=>$v){
            $hasKv = self::find($k);
            if($hasKv){
                $hasKv->val = $v;
                $hasKv->save();
            }else{
                self::create(['name'=>$k,'val'=>$v]);
            }
        }

    }

}
