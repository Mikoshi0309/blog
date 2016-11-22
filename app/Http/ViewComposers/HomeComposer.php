<?php
namespace App\Http\ViewComposers;


use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Contracts\View\View;

class HomeComposer
{
    protected $navs;
    protected $new;
    protected $hot;

    public function __construct(Navs $navs,Article $article)
    {
        $this->navs = $navs;
        $this->article = $article;

    }

    public function compose(View $view){
        $data['navs'] = $this->navs->all();

        $data['new'] = $this->article->orderBy('art_time','desc')->take(8)->get();
        $data['hot'] = $this->article->orderBy('art_view','desc')->take(5)->get();
        $view->with($data);
//        $view->with('new',$new);
//        $view->with('hot',$hot);
    }
}