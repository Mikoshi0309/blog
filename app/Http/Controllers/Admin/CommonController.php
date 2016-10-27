<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    public function upload(){
        $file = Input::file('Filedata');
        if($file->isValid()){
            //$realpath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
            $newname = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file->move(base_path().'/uploads',$newname);
            $filepath = 'uploads/'.$newname;
            return $filepath;
        }
    }
}
