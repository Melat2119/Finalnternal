<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        // 'name',
        // 'department',
        // 'status',
        // 'file_url',
        // ...other fields...
          'title',
        'department',
        'type',
        'file_path',
        'uploaded_by',
        'status',
        'approved_by',
        'approval_comment',
    ];
}

