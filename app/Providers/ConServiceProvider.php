<?php

namespace App\Providers;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ConServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $navs = Navs::all();
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        $hot = Article::orderBy('art_view','desc')->take(5)->get();
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
