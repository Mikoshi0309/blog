<?php

namespace App\Http\Controllers\Auth;
use Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;


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

    use AuthenticatesAndRegistersUsers;//, ThrottlesLogins;

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
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
//测试手动登录
    public function testlogin(){
//        if(Auth::check()){
//
//        }
//        if(Auth::viaRemember()){
//            dd(123);
//        }else{
//            dd(234);
//        }
        return view('auth.login');
    }
//测试登录执行
    public function authenticate( Request $request){
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password],$request->remember)){

            return redirect()->intended('admin/');
        }else{
            return redirect('/login');
        }
        /**********************注册直接登录****************/
//        $this->validate($request,[
//            'name' => 'required|max:255',
//            'email' => 'required|email|max:255|unique:user',
//            'password' => 'required|min:6|confirmed',
//        ]);
//        auth()->login($this->create($request->all()));
//        return redirect($this->redirectPath());
    }


    public function testlogout(){
        Auth::logout();
    }

    public function weibo() {
        return \Socialite::with('weibo')->redirect();
        // return \Socialite::with('weibo')->scopes(array('email'))->redirect();
    }


    public function callback() {
        $oauthUser = \Socialite::with('weibo')->user();

        var_dump($oauthUser->getId());
        var_dump($oauthUser->getNickname());
        var_dump($oauthUser->getName());
        var_dump($oauthUser->getEmail());
        var_dump($oauthUser->getAvatar());
    }
}
