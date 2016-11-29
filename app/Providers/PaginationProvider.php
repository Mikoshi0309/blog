<?php

namespace App\Providers;

use App\NewPaginationPresenter;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;



class PaginationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        Paginator::presenter(function (AbstractPaginator $paginate){
                return new NewPaginationPresenter($paginate);
        });


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
