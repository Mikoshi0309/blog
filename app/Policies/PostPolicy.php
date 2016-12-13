<?php

namespace App\Policies;

use App\Http\Model\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user,Article $article){

       // dd($article);
        return $user->id === $article->user_id;
    }
}
