<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'art_id';
    public $timestamps = false;
    protected $guarded = ['tags'];

    public function category(){
        return $this->belongsTo('App\Http\Model\Category','cate_id','cate_id');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function tags(){
    return $this->belongsToMany(Tag::class,'article_tag','art_id');
}
}
