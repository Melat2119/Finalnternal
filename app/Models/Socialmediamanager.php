<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socialmediamanager extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function documents()
    {
        return $this->belongsToMany(\App\Models\Document::class, 'document_socialmediamanager', 'socialmediamanager_id', 'document_id');
    }
}
