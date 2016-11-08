<?php

namespace App\Listeners;

use App\Events\ArticleView;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;

class ArticleViewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  ArticleView  $event
     * @return void
     */
    public function handle(ArticleView $event)
    {
        $article = $event->article;
        //if(!$this->hasViewedBlog($article)){
            $article->art_view = $article->art_view+1;
            $article->save();
            //$this->storeViewedBlog($article);
        //}
    }

    protected function hasViewedBlog($article){
        dd($this->getViewedblogs());
        return array_key_exists($article->art_id,$this->getViewedblogs());
    }
    protected function getViewedBlogs(){
        return $this->session->get('viewed_articles',[]);
    }
    protected function storeViewedBlog($article){
        $key = 'viewed_articles'.$article->art_id;
        $this->session->put($key,time());
    }
}
