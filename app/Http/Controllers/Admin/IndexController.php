<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;



class IndexController extends CommonController
{
    public function index(){
       return view('admin.index');
    }
    public function info(){
        return view('admin.info');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pass(){
        if($input = Input::all()){
            $rules = [
              'password'=>'required|between:6,20|confirmed',
            ];
            $mess = [
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须在6到20位之间！',
                'password.confirmed'=>'新密码和确认密码不一样！',
            ];
            $var = Validator::make($input,$rules,$mess);
            if($var->passes()){
                $user = User::first();
                $_pass = Crypt::decrypt($user->user_pass);
                if($_pass == $input['password_o']){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','修改成功!');
                }else{
                    return back()->with('errors','原密码错误!');
                }
            }else{
                return redirect('admin/pass')->withErrors($var);
            }
        }else{
            return view('admin.pass');
        }

    }
}
