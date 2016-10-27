<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Link;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Link::orderBy('link_order','asc')->get();
        return view('admin.link.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.link.add');
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
            'link_name'=>'required',
            'link_url'=>'required'
        ];
        $mess = [
            'link_name.required'=>'友情链接名称不能为空',
            'link_url.required'=>'友情链接url不能为空',
        ];
        $var = Validator::make($input,$rules,$mess);
        if($var->passes()){
            $re = Link::create($input);
            if($re){
                return redirect('admin/link');
            }else{
                return back()->with('errors','添加错误');
            }
        }else{
            return redirect('admin/link/create')->withErrors($var);
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = Link::find($id);
        return view('admin.link.edit',compact('file'));
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
            'link_name'=>'required',
            'link_url'=>'required'
        ];
        $mess = [
            'link_name.required'=>'友情链接名称不能为空',
            'link_url.required'=>'友情链接url不能为空',
        ];
        $vali = Validator::make($data,$rules,$mess);
        if($vali->passes()){
            $val = Link::where('link_id',$id)->update($data);
            if($val){
                return redirect('admin/link');
            }else{
                return back()->with("errors","更新信息失败");
            }
        }else{
            return redirect("admin/link/{$id}/edit")->withErrors($vali);
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
        $re = Link::where('link_id',$id)->delete();
        if($re){
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
    public function changeorder()
    {
        $input = Input::all();
        if(!is_int(intval($input['link_order']))){
            $data = [
                'status'=>1,
                'msg' => '更新失败',
            ];
        }else{
            $link = Link::find($input['link_id']);
            $link->link_order = $input['link_order'];
            $re = $link->update();
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
        }

        return $data;
    }
}
