<?php

namespace App;

//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
   // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'user';
    protected $fillable = [
        'name', 'email', 'password',
    ];
    public $timestamps = false;
    //protected $primaryKey = 'user_id';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public  function test(){
        return  $this->table;
    }
    public function articles(){
        return $this->hasMany('App\Http\Model\article','user_id');
    }
}
