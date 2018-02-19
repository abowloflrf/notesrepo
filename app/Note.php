<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'author', 'title', 'content','category','is_public'
    ];

    public function author()
    {
        return $this->belongsTo('App\User','author','email');
    }
}
