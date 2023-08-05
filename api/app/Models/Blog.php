<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Blog extends Model
{
    use HasUuids, HasFactory;

    protected $connection = 'mongodb';

    protected $fillable = [
        'title',
        'details',
        'content',
        'user_id'
    ];
}
