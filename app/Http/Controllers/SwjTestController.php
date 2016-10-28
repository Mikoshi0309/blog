<?php

namespace App\Http\Controllers;

use App\SwjTest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;

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

}
