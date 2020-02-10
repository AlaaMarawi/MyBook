<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    //protected $table='user';
     //can change p key:
     public $primaryKey= 'id';
     //Automatically manage my created_at and updated_at columns
     public $timestamps = false;

     protected $dates = [
       // 'created_at',
        // 'updated_at',
        'birth_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relationship with post model:
    public function posts (){
        return $this->hasmany('App\Post'); //a user has many posts (one to many)
    }
}
