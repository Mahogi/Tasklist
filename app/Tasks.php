<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'user_id',
        'creator', 
        'task', 
        'important',
        'complete',
    ];

    public $timestamps = false;



    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
