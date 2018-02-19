<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'author', 'title', 'content','category'
    ];

    public function author()
    {
        return $this->belongsTo('App\User','author','email');
    }
}
