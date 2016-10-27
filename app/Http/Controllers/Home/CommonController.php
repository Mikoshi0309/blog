<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use Illuminate\Http\Request;
use App\Http\Model\Navs;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;


class CommonController extends Controller
{
    public function __construct(){
        $navs = Navs::all();
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        $hot = Article::orderBy('art_view','desc')->take(5)->get();
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }
}
