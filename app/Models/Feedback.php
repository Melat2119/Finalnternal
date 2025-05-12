<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'developer_id',
        'sale_id',
        'message',
    ];

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
}
