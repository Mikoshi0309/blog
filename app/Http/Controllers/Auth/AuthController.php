<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    //use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'admin/';
    protected $redirectAfterLogout = 'admin/';
    //protected $username = 'user_name';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'user_name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
//测试手动登录
    public function testlogin(){
        if(Auth::viaRemember()){
            dd(123);
        }else{
            dd(234);
        }
        return view('auth.login');
    }
//测试登录执行
    public function authenticate( Request $request){
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password],$request->remember)){
              if(Auth::viaRemember()){
                  dd(123);
              }else{
                  dd(234);
              }
            //return redirect('admin/');
        }else{
            dd(123);
        }
    }
    public function testlogout(){
        Auth::logout();
    }
}
