<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'email', 'all_todos',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'email', 'email');
    }
}
