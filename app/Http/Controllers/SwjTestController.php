<?php

namespace App\Http\Controllers;

use App\SwjTest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Redis;

class SwjTestController extends Controller
{
    public function test(){
        $data['chj'] = 'asdadsadsa';
        $data['swj'] = 'asdadsadsa';
        Cache::forget('keyvalue');
        SwjTest::savecol($data);
    }

    public function extest(){
        $kv = Cache::get('keyvalue');
        $kv = unserialize($kv);
        if(is_array($kv) && count($kv)){
            return view('welcome')->withTest($kv);
        }else{
            $keyvalue = SwjTest::all();
            foreach($keyvalue as $val){
                $data[$val->name] = $val->val;
            }
            Cache::forever('keyvalue',serialize($data));
        }

        return view('welcome')->withTest($data);

    }

    public function sendMail(){
        $data = ['email'=>'371608656@qq.com', 'name'=>'徐文志'];//,'img'=>'C:\wamp\www\code\uploads\20161024111437390.jpg'
        Mail::send('activemail', $data, function($message) use($data)
        {
            $message->to('371608656@qq.com', '徐文志')->cc('1071499285@qq.com','asadsa')->subject('欢迎注册我们的网站，请激活您的账号！');
        });
//        Mail::raw('text to email',function($mess){
//            $mess->to('371608656@qq.com', '徐文志')->cc('1071499285@qq.com','asadsa')->subject('欢迎注册我们的网站，请激活您的账号！');
//            $mess->attach('C:\wamp\www\code\uploads\20161024111437390.jpg', ['as' => 'swj.jpg', 'mime' => 'image/jpeg']);
//        });
    }


    public function testredis(){
        //$redis = Redis::connection();
       // dd($redis);
        $data = 'adsadadsasdasda';
       // Redis::set('name',$data);
        //$val = Redis::lrange('names',5,10);
        Redis::del('name');
    }
    
}
