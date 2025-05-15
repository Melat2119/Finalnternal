<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function documents()
    {
        return $this->belongsToMany(\App\Models\Document::class, 'document_reception', 'reception_id', 'document_id');
    }
}
