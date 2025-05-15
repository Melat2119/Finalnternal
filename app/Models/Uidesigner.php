<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uidesigner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class, 'uidesigner_id');
    }
}
