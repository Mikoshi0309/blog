<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{

    protected $basePath;
    protected $pathclass;

    function __construct(){
        converClassPath(__CLASS__);
        $this->basePath = Config::get('path.adminBaseViewPath');
        $this->pathclass = Config::get('path.class');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tag::all();
        return view($this->basePath.$this->pathclass.'.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->basePath.$this->pathclass.'.add');
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
        $data['name'] = Tag::filterTagName($data['name']);
        $rules = [
            'name'=>'required|alpha',
        ];
        $mes = [
            'name.required'=>'请填写名称',
        ];
        $vali = Validator::make($data,$rules,$mes);
        if($vali->passes()){
            $re = Tag::create($data);
            if($re){
                return redirect('admin/tag');
            }else{
                return redirect('admin/tag/create')->withErrors('插入失败')->withInput();
            }
        }else{
            return redirect('admin/tag/create')->withErrors($vali);
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
    public function edit($id)
    {
        $data = Tag::find($id);
        return view($this->basePath.$this->pathclass.'.edit',compact('data'));
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
        $rules = [
            'name'=>'required|alpha',
        ];
        $mes = [
            'name.required'=>'请填写名称',
        ];
        $data = $request->only('name');
        $data['name'] = Tag::filterTagName($data['name']);
        $vali = Validator::make($data,$rules,$mes);
        if($vali->passes()){
            $re = Tag::where('id',$id)->update($data);
            if($re){
                return redirect('admin/tag');
            }else{
                return back()->withErrors('更新失败');
            }
        }else{
            return redirect('admin/tag/'.$id.'/edit')->withErrors($vali);
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
        $re = Tag::where('id',$id)->delete();
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

    public function __destruct(){
        Config::set('path.class','');
    }
}
