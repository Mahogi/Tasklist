<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'creator', 
        'task', 
        'important',
    ];

    public $timestamps = false;

}
