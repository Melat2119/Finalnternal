<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'description',
    ];
    public function document(){
        return $this->belongsToMany(Document::class,'document_versions');
    }
}
