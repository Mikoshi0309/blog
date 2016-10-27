<?php

namespace App\Http\Controllers\Home;


use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Link;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends CommonController
{
    public function index(){

        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        $data = Article::orderBy('art_time','desc')->paginate(5);
        $links = Link::orderBy('link_order','asc')->get();
        return view('home.index',compact('pics','hot','data','new','links'));
    }
    public function cate($cate_id){

        if(!Category::find($cate_id)){
            abort(404);
        }
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
        //查看次数自增
        Category::where('cate_id',$cate_id)->increment('cate_view');
        $cate = Category::find($cate_id);
        $submenu = Category::where('cate_pid',$cate_id)->get();
        return view('home.list',compact('cate','data','submenu'));
    }
    public function article($art_id){
        if(!Article::find($art_id)){
            abort(404);
        }
        $data = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');

        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $con_data = Article::where('cate_id',$data->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.new',compact('data','article','con_data'));
    }
}
