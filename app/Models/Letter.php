<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable = [
        'subject',
        'content',
        'department',
        'status',
        // ...other fields...
    ];
}
