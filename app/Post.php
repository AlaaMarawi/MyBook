<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $primaryKey= 'id';
    public $timestamps = true;

    // createing relation between models
    public function user(){
        return $this->belongsTo('App\User'); // a post belongs to a user
    }






}
