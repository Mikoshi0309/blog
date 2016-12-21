<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\Parameter;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(10);
        return view('admin.article.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

            $data = Category::getCategoryTree();
            $tags = Tag::all();
        return view('admin.article.add',compact('data','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['art_time'] = time();
        //$data['user_id'] = Auth::user()->user_id;
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        $mess = [
            'art_title.required' => "文章标题必须填写",
            'art_content.required' => "文章内容必须填写",
        ];
        $vali = Validator::make($data,$rules,$mess);
        if($vali->passes()){
            if(!empty($data['tags'])){
                $ids = [];
                foreach ($data['tags'] as $tagname){
                    $tag = Tag::firstOrCreate(['name'=>$tagname]);
                    array_push($ids,$tag->id);
                }
            }

            $re = Auth::user()->articles()->create($data);
            if($re){
                $re->tags()->sync($ids);
                //Redis::zadd($re->cate_id,$re->art_id,$re->art_id);
                //Redis::zadd('article_all',$re->art_id,$re->art_id);
                return redirect('admin/article');
            }else{
                return back()->withInput()->with('errors','文章添加失败');
            }
        }else{
            return back()->withInput()->withErrors($vali);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $data = Category::getCategoryTree();
        $file = Article::with(['tags'])->find($id);

//        if(Gate::denies('update-post',$file)){
//            return back()->with('errors',"你没有权限");
//        }
        /*if($request->user()->cannot('update-post',$file)){
            return back()->with('errors',"你没有权限");
        }*/

       /*if(Gate::denies('update',$file)){
            return back()->with('errors',"你没有权限");
        }*/
        
        //$this->authorize('update',$file);

        $tags = Tag::all();
        return view('admin/article/edit',compact('data','file','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token','_method');
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        $mess = [
            'art_title.required' => "文章标题必须填写",
            'art_content.required' => "文章内容必须填写",
        ];
        $vali = Validator::make($data,$rules,$mess);
        if($vali->passes()){
            if($data['tags']){

                $ids= [];
                foreach($data['tags'] as $tagname){
                    $tag = Tag::firstOrCreate(['name'=>$tagname]);
                    array_push($ids,$tag->id);
                }
            }
            unset($data['tags']);
            //Article::findOrNew($id)->save($attributes);
            $re = Article::where('art_id',$id)->update($data);
            //if($re){
                Article::find($id)->tags()->sync($ids);
                //$new_data = Article::all();
                //Redis:set('article_list',$new_data);
                return redirect('admin/article');
           // }else{
                //return back()->with('errors','更新失败');
           // }
        }else{
            return back()->withErrors($vali);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Article::find($id);
        $re = $data->delete();
        if($re){
            Redis::zremrangebyscore($data->cate_id,$id,$id);
            Redis::zremrangebyscore('article_id',$id,$id);
            $data = [
                'status'=>0,
                'msg'=>'删除成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除失败',
            ];
        }
        return $data;
    }
}
