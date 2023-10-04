<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Todo extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'todos';

    protected $fillable = [
        'title',
        'description'
    ];
}