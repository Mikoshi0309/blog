<?php

namespace App\Http\Controllers\Home;


use App\Events\ArticleView;
use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Link;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;

class IndexController extends CommonController
{
    public function index(Request $request){

        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        //redis分页获取数据
//          $page = $request->page ? $request->page : 1;
 //         $pagesize = 3;
//        $offset=$pagesize*($page - 1);
//        $ids = Redis::zrange('article_all',$offset,$pagesize*$page-1);
//        $collect = collect($ids);
//        $data = $collect->map(function($item,$key){
//            return Article::find($item);
//        });
        //缓存分页对象
        //$data = unserialize(Redis::get('oarticle_all'));
        //if(!$data){
            //对象存储前序列化
            $data = Article::orderBy('art_time','desc')->paginate(4);
            //$sdata = serialize($data);
           // Redis::set('oarticle_all',$sdata);
            // $data = Article::orderBy('art_time','desc')->paginate(3);
        //}


        $links = Link::orderBy('link_order','asc')->get();
        return view('home.index',compact('pics','hot','data','new','links'));
    }
    public function cate($cate_id){

        if(!Category::find($cate_id)){
            abort(404);
        }
        //$data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
        //一对多关联关系
        $data = Category::find($cate_id)->articles()->orderBy('art_time','desc')->paginate(4);
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
        //一对多——相对的关联
        //$test = Article::find($art_id)->category;


        //查看次数自增
        //Article::where('art_id',$art_id)->increment('art_view');
        //监听器自增
        $art = Article::where('art_id',$art_id)->firstOrFail();
        Event::fire(new ArticleView($art));


        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $con_data = Article::where('cate_id',$data->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.new',compact('data','article','con_data'));
    }
}
