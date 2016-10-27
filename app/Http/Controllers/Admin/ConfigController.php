<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        foreach($data as $k=>$v){
            switch ($v->conf_type){
                case 'input':
                    $data[$k]->_html = '<input class="lg" type="text" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea class="lg" type="text" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arr = explode(',',$v->conf_value);
                    $str = '';
                    foreach($arr as $key=>$val){
                        list($num,$hz) = explode('|',$val);
                        $c = $v->conf_content == $num ? ' checked ' : '';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$num.'" '.$c.'>'.$hz.'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }

        return view('admin.config.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.config.add');
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
            'conf_name'=>'required',
            'conf_title'=>'required'
        ];
        $mess = [
            'conf_name.required'=>'配置项名称不能为空',
            'conf_title.required'=>'配置项标题不能为空',
        ];
        $var = Validator::make($input,$rules,$mess);
        if($var->passes()){
            $re = Config::create($input);
            if($re){
                $this->putFile();
                return redirect('admin/config');
            }else{
                return back()->with('errors','添加错误');
            }
        }else{
            return redirect('admin/config/create')->withErrors($var);
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
        $file = Config::find($id);
        return view('admin.config.edit',compact('file'));
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
            'conf_name'=>'required',
            'conf_title'=>'required'
        ];
        $mess = [
            'conf_name.required'=>'配置名称不能为空',
            'conf_title.required'=>'配置标题不能为空',
        ];
        $vali = Validator::make($data,$rules,$mess);
        if($vali->passes()){
            $val = Config::where('conf_id',$id)->update($data);
            if($val){
                $this->putFile();
                return redirect('admin/config');
            }else{
                return back()->with("errors","更新信息失败");
            }
        }else{
            return redirect("admin/config/{$id}/edit")->withErrors($vali);
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
        $re = Config::where('conf_id',$id)->delete();
        if($re){
            $this->putFile();
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
        if(!is_int(intval($input['conf_order']))){
            $data = [
                'status'=>1,
                'msg' => '更新失败',
            ];
        }else{
            $conf = Config::find($input['conf_id']);
            $conf->conf_order = $input['conf_order'];
            $re = $conf->update();
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

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changecontent()
    {
        $input = Input::all();
        foreach($input['conf_id'] as $k=>$val){
            Config::where('conf_id',$val)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置成功');
    }

    /**
     *
     */
    public function putFile()
    {
        $data = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\web.php';
        $data = "<?php \n return \n".var_export($data,true).";";
        file_put_contents($path,$data);
    }

}
