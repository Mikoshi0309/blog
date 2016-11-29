<?php

namespace App;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Pagination\BootstrapThreePresenter;
use Illuminate\Pagination\UrlWindow;

class NewPaginationPresenter extends BootstrapThreePresenter
{

//    protected $paginator;
//
//    public function __construct(PaginatorContract $paginator,UrlWindow $window = null)
//    {
//        $this->paginator = $paginator;
//        $this->window = is_null($window) ? UrlWindow::make($paginator) : $window->get();
//    }


    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<ul class="pagination">%s %s %s</ul>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }

        return '';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li class="disabled"><span>'.$text.'</span></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li class="active"><span>'.$text.'</span></li>';
    }
}


