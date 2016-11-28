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
    public static function uploadImg($field)
    {
        if (Request::hasFile($field)) {
            $pic = Request::file($field);
            if ($pic->isValid()) {
                $newName = md5(rand(1, 1000) . $pic->getClientOriginalName()) . "." . $pic->getClientOriginalExtension();
                $pic->move('uploads', $newName);
                return $newName;
            }
        }
        return '';
    }
}
