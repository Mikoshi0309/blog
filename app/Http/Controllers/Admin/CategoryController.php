<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate = new Category;
        return view('admin.category.index')->with('data',$cate->tree());
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


       // $data = Redis::get('category_list');

        //$data = collect(json_decode($data));
        //if(!$data){
            //$data = Category::where('cate_pid',0)->get();
        //}
        $data = Category::getCategoryTree();
        //dd(json_decode($data,true));
        return view("admin.category.add",compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $rules = [
            'cate_name'=>'required',
        ];
        $mess = [
            'cate_name.required'=>'分类名称不能为空',
        ];
        $var = Validator::make($input,$rules,$mess);
        if($var->passes()){
            $re = Category::create($input);
            if($re){
                //$data = Category::where('cate_pid',0)->get();
                //Redis::set('category_list',$data);
                return redirect('admin/category');
            }else{
                return back()->with('errors','添加错误');
            }
        }else{
            return redirect('admin/category/create')->withErrors($var);
        }

       // Category::
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
    public function edit($id)
    {
        $file = Category::find($id);
        //$data = Redis::get('category_list');
        //$data = json_decode($data);
        //if(!$data){
            //$data = Category::where('cate_pid',0)->get();
       // }
        $data = Category::getCategoryTree();
        return view('admin.category.edit',compact('file','data'));
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
            'cate_name'=>'sometimes|required'
        ];
        $mess = [
            'cate_name.required'=>"分类名称必须填写",
        ];
        $vali = Validator::make($data,$rules,$mess);
        $vali->after(function ($vali) use($id,$data){
            $val = Category::where('cate_id',$id)->update($data);
            if(!$val) {
                $vali->errors()->add('test', '更新失败');
            }
            //$data = Category::where('cate_pid',0)->get();
            //Redis::set('category_list',$data);

        });
        //dd($vali->errors()->first('test','<p>:message</p>'));
        if($vali->fails()){
            return redirect("admin/category/{$id}/edit")->withErrors($vali);
        }
        return redirect('admin/category');

//        if($vali->passes()){
//            $val = Category::where('cate_id',$id)->update($data);
//            if($val){
//                $data = Category::where('cate_pid',0)->get();
//                Redis::set('category_list',$data);
//                return redirect('admin/category');
//            }else{
//                return back()->with("errors","更新信息失败");
//            }
//        }else{
//            return redirect("admin/category/{$id}/edit")->withErrors($vali);
//        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re = Category::where('cate_id',$id)->delete();
        Category::where('cate_pid',$id)->update(['cate_pid'=>0]);
        if($re){
            //$data = Category::where('cate_pid',0)->get();
           // Redis::set('category_list',$data);
            $data = [
                'status' => 0,
                'msg' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '删除失败'
            ];
        }
        return $data;
    }

    public function changeorder(Request $request)
    {

        $input = Input::all();
//        $rules = [
//            'cate_order'=>'sometimes|required|integer',
//        ];
//        $mess = [
//            'cate_order.required' => '排序必须项',
//            'cate_order.integer' => '必须是数字'
//        ];
//
//        $val = Validator::make($input,$rules,$mess);

        $this->validate($request,[
            'cate_order'=>'sometimes|required|integer',
        ]);

        //判断ajax请求
        //if($request->ajax()){
            //dd($val->errors());
        //}
       // if($val->passes()){

           $cate = Category::find($input['cate_id']);
            $cate->cate_order = $input['cate_order'];
            $re = $cate->update();
            if($re){
                $data = [
                    'status'=>0,
                    'msg' => '更新成功',
                ];
            }else{
                $data = [
                    'status'=>1,
                    'msg' => '更新失败',
                ];
            }
            return $data;
        //}
//        if(!is_int(intval($input['cate_order']))){
//            $data = [
//                'status'=>1,
//                'msg' => '更新失败',
//            ];
//        }else{
//            $cate = Category::find($input['cate_id']);
//            $cate->cate_order = $input['cate_order'];
//            $re = $cate->update();
//            if($re){
//                $data = [
//                    'status'=>0,
//                    'msg' => '更新成功',
//                ];
//            }else{
//                $data = [
//                    'status'=>1,
//                    'msg' => '更新失败',
//                ];
//            }
//        }

    }
}
