<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

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
        $data = (new Category())->tree();
        return view('admin.article.add',compact('data'));
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
            $re = Article::create($data);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','文章添加失败');
            }
        }else{
            return back()->withErrors($vali);
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

        $data = (new Category())->tree();
        $file = Article::find($id);
        /*if(Gate::denies('update-post',$file)){
            return back()->with('errors',"你没有权限");
        }*/
        /*if($request->user()->cannot('update-post',$file)){
            return back()->with('errors',"你没有权限");
        }*/

       /*if(Gate::denies('update',$file)){
            return back()->with('errors',"你没有权限");
        }*/

        $this->authorize('update',$file);

        return view('admin/article/edit',compact('data','file'));
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
            $re = Article::where('art_id',$id)->update($data);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','更新成功');
            }
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
        $re = Article::where('art_id',$id)->delete();
        if($re){
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
